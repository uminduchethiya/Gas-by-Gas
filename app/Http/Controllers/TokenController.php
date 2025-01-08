<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;

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
            ]);
            $token = Token::findOrFail($id);
           
            $token->status = $request->status;
            $token->save();

            return response()->json(['message' => 'Token status updated successfully']);
        }

}
