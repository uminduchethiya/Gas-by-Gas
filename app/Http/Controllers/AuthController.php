<?php

namespace App\Http\Controllers;

use App\Consts\UserRoleConst;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginview()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                if ($user->role_id == UserRoleConst::USER) {
                    return redirect()->route('home')->with('status', 'Logged in successfully!');
                }
                if ($user->role_id == UserRoleConst::ADMIN) {
                    return redirect()->route('dashboard')->with('status', 'Welcome to the dashboard!');
                }
                if ($user->role_id == UserRoleConst::MANAGER) {
                    // Redirect manager to their specific dashboard
                    return redirect()->route('manager.dashboard')->with('status', 'Welcome to the Manager Dashboard!');
                }
            }

            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function registeview()
    {
        $branches = Branch::all();
        return view('auth.register', compact('branches'));
    }

    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'contact_number' => 'nullable|string',
                'address' => 'nullable|string',
                'branch' => 'required|exists:branches,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'role_id' => UserRoleConst::USER,
                'branch_id' => $request->branch,
            ]);



            return redirect()->route('login')->with('status', 'Registration successful! Please log in.');
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during registration. Please try again.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }
}
