<?php

namespace App\Http\Controllers;

use App\Consts\UserRoleConst;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


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

                // Check if the user's status is active
                if ($user->status !== 'active') {
                    Auth::logout(); // Log the user out if status is not active
                    return back()->withErrors([
                        'email' => 'Your account is not active. Please contact the admin.',
                    ]);
                }

                // Check if the user is an organization, and prevent login
                if ($user->role_id == UserRoleConst::ORGANIZATION) {
                    return redirect()->route('home')->with('status', 'Logged in as Organization!');
                }

                // Redirect based on user role
                if ($user->role_id == UserRoleConst::USER) {
                    return redirect()->route('home')->with('status', 'Logged in successfully!');
                }
                if ($user->role_id == UserRoleConst::ADMIN) {
                    return redirect()->route('admin.dashboard')->with('status', 'Welcome to the dashboard!');
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
        $outlets = Outlet::all();
        return view('auth.register', compact('outlets'));
    }

    public function register(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'contact_number' => 'nullable|string',
                'address' => 'nullable|string',
                'nic' => 'nullable|string',
                'outlet' => 'required|exists:outlets,id',
                'is_organization' => 'sometimes|boolean',
                'verification_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048|required_if:is_organization,true',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }

            // Convert is_organization to a boolean
            $isOrganization = filter_var($request->is_organization, FILTER_VALIDATE_BOOLEAN);

            // Handle file upload if 'is_organization' is true and a file is provided
            $verificationFilePath = null;
            if ($isOrganization && $request->hasFile('verification_file')) {
                $verificationFilePath = $request->file('verification_file')->store('verification_files', 'public');
            }

            // Create the user with status based on the organization
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'nic' => $request->nic,
                'role_id' => $isOrganization ? UserRoleConst::ORGANIZATION : UserRoleConst::USER,
                'outlet_id' => $request->outlet,
                'is_organization' => $isOrganization,
                'verification_file' => $verificationFilePath,
                'status' => $isOrganization ? 'deactive' : 'active', // Set status to 'deactive' for organizations
            ]);

            // Return success response
            return redirect()->route('login')->with('status', 'Registration successful! Please log in.');
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during registration. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function registerByAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'contact_number' => 'nullable|string',
                'address' => 'nullable|string',
                'nic' => 'nullable|string|unique:users',
                'outlet' => 'required|exists:outlets,id',
                'is_organization' => 'sometimes|boolean',
                'verification_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048|required_if:is_organization,true',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $isOrganization = filter_var($request->is_organization, FILTER_VALIDATE_BOOLEAN);

            $verificationFilePath = null;
            if ($isOrganization && $request->hasFile('verification_file')) {
                $verificationFilePath = $request->file('verification_file')->store('verification_files', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'nic' => $request->nic,
                'role_id' => $isOrganization ? UserRoleConst::ORGANIZATION : UserRoleConst::USER,
                'outlet_id' => $request->outlet,
                'is_organization' => $isOrganization,
                'verification_file' => $verificationFilePath,
                'status' => $isOrganization ? 'deactive' : 'active',
            ]);

            return response()->json(['success' => 'Customer created successfully!']);
        } catch (\Exception $e) {
            // Handle any exceptions
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    public function updateCustomer(Request $request)
    {
        try {

            // Validate incoming data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
                'contact_number' => 'nullable|string',
                'address' => 'nullable|string',
                'nic' => 'nullable|string|unique:users,nic,' . $request->id,
                'outlet' => 'required|exists:outlets,id',

            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::findOrFail($request->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'nic' => $request->nic,
                'outlet_id' => $request->outlet,

            ]);

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            return response()->json(['success' => 'Customer updated successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
