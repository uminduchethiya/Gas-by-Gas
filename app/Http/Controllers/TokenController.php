<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\User;
use App\Models\GasCylinder;
use App\Models\OutletToken;

use App\Models\TokenHistory;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class TokenController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $isActive = $request->input('isActive');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $tokens = Token::select('tokens.id', 'tokens.status', 'tokens.isActive', 'tokens.description', 'tokens.created_at', 'gas_cylinders.name as gas_cylinder_name', 'users.name as user_name') // Add users.name to select user name
            ->leftJoin('gas_cylinders', 'tokens.cylinder_type_id', '=', 'gas_cylinders.id')
            ->leftJoin('users', 'tokens.user_id', '=', 'users.id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('tokens.status', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('gas_cylinders.name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('tokens.status', '=', $status);
            })
            ->when($isActive, function ($query, $isActive) {
                return $query->where('tokens.isActive', '=', $isActive);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        $users = User::where('isActive', 1)
            ->where('role_id', 3);
        $gasCylinders = GasCylinder::all();

        return view('manager.token.index', ['tokens' => $tokens, 'users' => $users, 'gasCylinders' => $gasCylinders]);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'reason' => 'nullable|string', // Reason is required only for specific statuses
        ]);

        DB::beginTransaction();

        try {
            $token = Token::findOrFail($id);

            if ($request->status === Token::STATUS_CANCELED && empty($request->reason)) {
                return response()->json(['error' => 'A reason is required when canceling a token'], 422);
            }

            // Log current status in token history
            TokenHistory::create([
                'token_id' => $token->id,
                'currentStatus' => $token->status,
                'updateStatus' => $request->status,
                'reason' => $request->reason ?? null,
                'updated_by' => Auth::id(),
            ]);

            // Update token status
            $token->status = $request->status;
            $token->save();

            DB::commit();

            return response()->json(['message' => 'Token status updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update token status', 'details' => $e->getMessage()], 500);
        }
    }

    public function issueToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'outlet_id' => 'required|exists:outlets,id',
            'cylinder_type_id' => 'required|exists:gas_cylinders,id',
        ]);

        // If validation fails, return the error messages
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $userId = $request->input('user_id');
        $outletId = $request->input('outlet_id');
        $cylinderTypeId = $request->input('cylinder_type_id');
        DB::beginTransaction();

        try {
            $activeTokensCount = Token::where('user_id', $userId)
                ->where('cylinder_type_id', $cylinderTypeId)
                ->whereIn('status', [Token::STATUS_PENDING, Token::STATUS_SCHEDULED])
                ->count();

            if ($activeTokensCount >= 2) {
                DB::rollBack();
                return response()->json(['error' => 'You cannot have more than 2 active tokens for this cylinder type.'], 400);
            }

            $branchToken = OutletToken::where('outlet_id', $outletId)
                ->where('cylinder_type_id', $cylinderTypeId)
                ->first();

            if (!$branchToken) {
                DB::rollBack();
                return response()->json(['error' => 'The selected branch does not have tokens for this cylinder type.'], 400);
            }

            if ($branchToken->currentTokens == 0) {
                DB::rollBack();
                return response()->json(['error' => 'No tokens are available for this cylinder type at the selected branch.'], 400);
            }

            $branchToken->decrement('currentTokens');

            $tokenCode = Str::uuid()->toString();
            $expiresAt = now()->addDays(14);

            $createdBy = auth()->id();

            // Create the token
            $token = Token::create([
                'user_id' => $userId,
                'outlet_id' => $outletId,
                'cylinder_type_id' => $cylinderTypeId,
                'status' => Token::STATUS_PENDING,
                'isActive' => 1,
                'description' => 'Token issued',
                'quantity' => 1,
                'expires_at' => $expiresAt,
                'token_code' => $tokenCode,
                'created_by' => $createdBy,
                'updated_by' => $createdBy,
            ]);

            TokenHistory::create([
                'token_id' => $token->id,
                'currentStatus' => $token->status,
                'updateStatus' => Token::STATUS_PENDING,
                'reason' => null,
                'updated_by' => Auth::id(),
            ]);
            DB::commit();

            return response()->json(['success' => 'Token issued successfully.', 'token' => $token], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Token issue failed', [
                'user_id' => $userId,
                'outlet_id' => $outletId,
                'cylinder_type_id' => $cylinderTypeId,
                'error' => $e->getMessage(),
            ]);

            // Return the error message
            return response()->json(['error' => 'An error occurred while issuing the token. Please try again later.', $e->getMessage()], 500);
        }
    }

}
