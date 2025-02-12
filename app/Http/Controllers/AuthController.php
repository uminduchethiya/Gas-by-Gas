<?php

namespace App\Http\Controllers;

use App\Consts\UserRoleConst;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\Outlet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\UserRegistration;
use App\Mail\CoparateRegistration;


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
                'contact_number' => [
                    'required',
                    'regex:/^\+94\d{9}$/', // Must start with +94 followed by 9 digits
                ],
                'address' => 'nullable|string',
                'nic' => [
                    'required',
                    'regex:/^\d{12}$|^\d{9}[vVxX]$/',
                    'unique:users'
                ],
                'outlet' => 'required|exists:outlets,id',
                'is_organization' => 'sometimes|boolean',
                'verification_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048|required_if:is_organization,true',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with('status', 'error')
                    ->with('message', $validator->errors()->first());
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

            if (!$isOrganization) {
                Mail::to($user->email)->send(new UserRegistration($user, url('/login-view')));
            } else {
                Mail::to($user->email)->send(new CoparateRegistration($user, url('/login-view')));

            }

            return redirect()->route('login')
                ->with('status', 'success')
                ->with('message', 'User registered successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', 'An error occurred during registration. Please try again.');
        }
    }


    public function registerByAdmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'contact_number' => [
                    'required',
                    'regex:/^\+94\d{9}$/', // Must start with +94 followed by 9 digits
                ],
                'address' => 'nullable|string',
                'nic' => [
                    'required',
                    'regex:/^\d{12}$|^\d{9}[vVxX]$/',
                    'unique:users'
                ],
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

            if (!$isOrganization) {
                Mail::to($user->email)->send(new UserRegistration($user, url('/login-view')));
            } else {
                Mail::to($user->email)->send(new CoparateRegistration($user, url('/login-view')));

            }



            return response()->json(['success' => 'Customer created successfully!']);
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

    public function showForgotPasswordForm()
    {
        return view('auth.forgotpassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(60);
        $email = $request->email;

        // Delete existing token if exists
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Insert new reset token
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Send email with reset link
        $resetLink = route('password.reset', ['token' => $token]);
        Mail::to($email)->send(new PasswordResetMail($resetLink));
        // Use your mail functionality here (e.g., Mail::to($email)->send(new PasswordResetMail($resetLink));)

        return back()->with('status', 'Password reset link has been sent to your email.');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.resetpassword', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find the reset token
        $resetRecord = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Update the user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
    }

    public function apiLogin(Request $request)
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
                    Auth::logout();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Your account is not active. Please contact the admin.'
                    ], 403);
                }

                $token = $user->createToken('authToken')->plainTextToken;

                $response = [
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role_id,
                        'token' => $token,
                    ]
                ];

                return response()->json($response, 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials. Please try again.'
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function APIregister(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'contact_number' => [
                    'required',
                    'regex:/^\+94\d{9}$/',
                ],
                'address' => 'nullable|string',
                'nic' => [
                    'required',
                    'regex:/^\d{12}$|^\d{9}[vVxX]$/',
                    'unique:users'
                ],
                'outlet' => 'required|exists:outlets,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'nic' => $request->nic,
                'role_id' => UserRoleConst::USER,
                'outlet_id' => $request->outlet,
                'is_organization' => false,
                'status' => 'active',
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            Mail::to($user->email)->send(new UserRegistration($user, url('/login-view')));

            return response()->json(['success' => 'User registered successfully!', 'token' => $token, 'user' => $user]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
