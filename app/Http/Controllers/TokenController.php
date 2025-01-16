<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\TokenHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        ->paginate(2); 
    
        
        return view('manager.token.index', ['tokens' => $tokens]);
        
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
}
