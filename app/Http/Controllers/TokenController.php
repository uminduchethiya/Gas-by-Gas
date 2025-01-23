<?php

namespace App\Http\Controllers;

use App\Models\GasCylinder;
use App\Models\Outlet;
use App\Models\OutletToken;
use App\Models\Token;
use App\Models\TokenHistory;
use App\Models\Stock;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Services\TwilioSmsService;
use Illuminate\Support\Str;

class TokenController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'pending');
        $isActive = $request->input('isActive');
        $sortBy = $request->input('sort_by', 'expires_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $loggedInUserOutletId = auth()->user()->outlet_id;


        $tokens = Token::select(
            'tokens.id',
            'tokens.status',
            'tokens.isActive',
            'tokens.description',
            'tokens.expires_at',
            'gas_cylinders.name as gas_cylinder_name',
            'users.name as user_name',
            'users.id as user_id',
            'users.contact_number as contact_number',
            'users.email as email',
        )
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
            ->where('tokens.outlet_id', '=', $loggedInUserOutletId)
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);




        $users = User::where('isActive', 1)
            ->where('role_id', 3)
            ->where('outlet_id', $loggedInUserOutletId)
            ->get();


        $gasCylinders = GasCylinder::all();

        return view('manager.token.index', [
            'tokens' => $tokens,
            'users' => $users,
            'gasCylinders' => $gasCylinders,
            "loggedInUserOutletId" => $loggedInUserOutletId
        ]);

    }

    public function update(Request $request, $id, TwilioSmsService $smsService)
    {
        $request->validate([
            'status' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $token = Token::findOrFail($id);

            if ($request->status === Token::STATUS_CANCELED && empty($request->reason)) {
                return response()->json(['error' => 'A reason is required when canceling a token'], 422);
            }


            if ($request->status === Token::STATUS_COMPLETE) {

                $currentStock = Stock::where('gas_cylinder_id', $token->cylinder_type_id)
                    ->where('quantity', '>', 0)
                    ->orderBy('id')
                    ->first();

                if ($currentStock) {

                    $currentStock->quantity -= 1;
                    $currentStock->save();
                } else {
                    return response()->json(['error' => 'No stock available for selecte cilinder type'], 404);
                }
            }
            if ($request->status === Token::STATUS_CANCELED) {
               

                $stock = OutletToken::where('outlet_id', $token->outlet_id)
                    ->where('cylinder_type_id', $token->cylinder_type_id)
                    ->first();
                if ($stock) {
                    $stock->increment(column: 'currentTokens');
                }
            }

            $user = $token->user;
            if (!$user || !$user->contact_number) {
                return response()->json(['error' => 'User contact number not found'], 404);
            }
            $countryCode = '+94';
            $userContactNumber = $user->contact_number;

            if (!str_starts_with($userContactNumber, $countryCode)) {
                $userContactNumber = $countryCode . ltrim($userContactNumber, '0');
            }



            TokenHistory::create([
                'token_id' => $token->id,
                'currentStatus' => $token->status,
                'updateStatus' => $request->status,
                'reason' => $request->reason ?? null,
                'updated_by' => Auth::id(),
            ]);

            $token->status = $request->status;
            $token->save();


            $message = "Your token  has been: {$request->status}. Thank you!";

            if ($request->status === Token::STATUS_CANCELED) {
                $message = "Your token  has been: {$request->status}. Please contct admin for more details!";
            }

            $smsResponse = $smsService->sendSms(
                $userContactNumber,
                $message
            );
            if (!$smsResponse['success']) {
                throw new \Exception('Failed to send SMS: ' . $smsResponse['error']);
            }
            DB::commit();
            return response()->json(['message' => 'Token status updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update token status', 'details' => $e->getMessage()], 500);
        }
    }

    public function issueToken(Request $request, TwilioSmsService $smsService)
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
                ->whereIn('status', [Token::STATUS_PENDING, Token::STATUS_SCHEDULED])
                ->count();

            if ($activeTokensCount >= 2) {
                DB::rollBack();
                return response()->json(['error' => 'You cannot have more than 2 active tokens.'], 400);
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

            $branchToken->decrement(column: 'currentTokens');

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
            $tokenUser = User::find($userId);
            $message = "Your token  has been: Created. Thank you!";

            $countryCode = '+94';
            $userContactNumber = $tokenUser->contact_number;

            if (!str_starts_with($userContactNumber, $countryCode)) {
                $userContactNumber = $countryCode . ltrim($userContactNumber, '0');
            }

            $smsResponse = $smsService->sendSms(
                $userContactNumber,
                $message
            );
            if (!$smsResponse['success']) {
                throw new \Exception('Failed to send SMS: ' . $smsResponse['error']);
            }
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
    public function getTokenHistoryByID($id)
    {
        try {
            $history = TokenHistory::where('token_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($history->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No history found for this token.']);
            }

            return response()->json([
                'success' => true,
                'history' => $history
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function tokenView()
    {
        $outlets = Outlet::all();

        $gasCylinders = GasCylinder::where('isActive', true)->get();

        $loggedInUserId = auth()->id();

        $assignedOutletId = auth()->user()->outlet_id;

        return view('user.tokenrequest', compact('outlets', 'assignedOutletId', 'gasCylinders', 'loggedInUserId'));
    }
    public function assignNewUserToToken(Request $request, TwilioSmsService $smsService)
    {
        $request->validate([
            'newUserId' => 'required|exists:users,id', // Validate the new user ID
            'tokenId' => 'required|exists:tokens,id', // Validate the token ID
        ]);

        DB::beginTransaction();

        try {
            $token = Token::findOrFail($request->tokenId);

            if ($token->user_id === (int) $request->newUserId) {
                return response()->json(['error' => 'The new user cannot be the same as the current user.'], 422);
            }


            $activeTokensCount = Token::where('user_id', $request->newUserId)
                ->whereIn('status', [Token::STATUS_PENDING, Token::STATUS_SCHEDULED])
                ->count();

            if ($activeTokensCount >= 2) {
                return response()->json(['error' => 'You cannot have more than 2 active tokens.'], 400);
            }
            $newUser = User::findOrFail($request->newUserId);


            $countryCode = '+94';
            $userContactNumber = $newUser->contact_number;

            if (!str_starts_with($userContactNumber, $countryCode)) {
                $userContactNumber = $countryCode . ltrim($userContactNumber, '0');
            }

            // Update the token's user
            $previousUserId = $token->user_id;
            $token->user_id = $newUser->id;
            $token->save();

            TokenHistory::create([
                'token_id' => $token->id,
                'currentStatus' => $token->status,
                'updateStatus' => Token::STATUS_REASIGNED,
                'reason' => 'User reassigned to another user',
                'updated_by' => Auth::id(),
            ]);

            $originalUser = User::findOrFail($token->user_id);
            $originalUserName = $originalUser->name;
            $originalUserContactNumber = $originalUser->contact_number;

        
            if (!str_starts_with($originalUserContactNumber, $countryCode)) {
                $originalUserContactNumber = $countryCode . ltrim($originalUserContactNumber, '0');
            }

            DB::commit();

            $originalUserContactNumber = "Dear {$originalUserName}, your token assing to new user. Please contact outlet for more details.";
            $smsResponse = $smsService->sendSms($originalUserContactNumber, $originalUserContactNumber);

            $message = "Dear {$newUser->name}, you have been assigned a new token (ID: {$token->id}). Please check your dashboard for details.";
            $smsResponse = $smsService->sendSms($userContactNumber, $message);



            return response()->json([
                'success' => true,
                'message' => 'User reassigned successfully and SMS notification sent.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Failed to reassign user to token.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

}
