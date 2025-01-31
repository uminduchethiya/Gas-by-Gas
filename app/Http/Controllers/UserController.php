<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GasCylinder;
use App\Models\Outlet;
use App\Models\Token;
use App\Models\TokenHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home_view()
    {
        $outlets = Outlet::all();
        $user = auth()->user();
        $gasCylinders = GasCylinder::where('isActive', true)->get();
        $loggedInUserId = auth()->id();
        $assignedOutletId = auth()->user()->outlet_id;
        $assignedStatus = auth()->user()->role_id;
        $loggedInUserRole = auth()->user()->role_id ?? null;
        return view('user.home', compact('outlets', 'assignedOutletId', 'gasCylinders', 'loggedInUserId', 'assignedStatus', 'loggedInUserRole'));
    }

    public function aboutus_view()
    {
        return view('user.aboutus');
    }

    public function countacus_view()
    {

        return view('user.contactus');
    }

    public function editprofile()
    {
        $user = Auth::user(); // Get logged-in user
        $outlets = Outlet::select('id', 'name')->get(); // Fetch outlet IDs & names
        return view('user.editprofile', compact('user', 'outlets'));
    }

    // Update User Profile
    public function update(Request $request)
    {
        $user = Auth::user(); // Get logged-in user

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'outlet_id' => 'nullable|exists:outlets,id',
            'nic' => 'required|string|max:20|unique:users,nic,' . $user->id,
        ]);

        try {
            // Update user details
            $user->update([
                'name' => $request->name,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'outlet_id' => $request->outlet_id,
                'nic' => $request->nic,
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }


    public function viewstatus()
{
    $userId = auth()->user()->id; // Get the current user's ID

    // Fetch all tokens for the user (including those with canceled status)
    $tokens = Token::where('user_id', $userId)
        ->with('cylinderType') // Get related gas cylinder name
        ->get();

    // Fetch all token histories related to the user's tokens (including canceled)
    $tokenHistories = TokenHistory::whereIn('token_id', $tokens->pluck('id'))
        ->with('token') // Fetch related token details
        ->orderBy('created_at', 'desc') // Order histories by latest creation date
        ->get();

    // Get the latest status for the view's current status flow
    $latestStatus = $tokens->sortByDesc('created_at')->first()->status ?? 'pending';

    return view('user.viewstatus', compact('tokens', 'latestStatus', 'tokenHistories'));
}

    
}
