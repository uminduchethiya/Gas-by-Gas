<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\User;
use App\Models\Token;


use App\Models\TokenHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CoparateCustomerAproval;

class CustomerController extends Controller
{



    public function index(Request $request)
    {
        // Default sort parameters
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        $search = $request->get('search');
        $status = $request->get('status');
        $isActive = $request->get('is_active', true);

        // Query users instead of outlets
        $users = User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.contact_number',
            'users.address',
            'users.nic',
            'users.status',
            'users.isActive',
            'outlets.Name as outlet_name',
            'outlets.id as outlet_id',
            'branches.name as branch_name'
        )
            ->leftJoin('outlets', 'users.outlet_id', '=', 'outlets.id')
            ->leftJoin('branches', 'outlets.branch_id', '=', 'branches.id')
            ->whereIn('role_id', [3, 4])

            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('users.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%')
                        ->orWhere('outlets.Name', 'like', '%' . $search . '%')
                        ->orWhere('branches.name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('users.status', '=', $status);
            })
            ->when($isActive, function ($query, $isActive) {
                return $query->where('users.isActive', '=', 1);
            })
            ->orderBy('users.' . $sortBy, $sortDirection) // Use dynamic sorting
            ->paginate(10);

        $outlets = Outlet::all();
        return view('manager.Customers.index', [
            'users' => $users,
            'outlets' => $outlets,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }
    public function Coparateindex(Request $request)
    {
        // Default sort parameters
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        $search = $request->get('search');
        $status = $request->get('status');
        $isActive = $request->get('is_active', true);
        $loggedInUserOutletId = auth()->user()->outlet_id;

        // Query users instead of outlets
        $users = User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.contact_number',
            'users.address',
            'users.nic',
            'users.status',
            'users.isActive',
            'users.verification_file',
            'outlets.Name as outlet_name',
            'outlets.id as outlet_id',
            'branches.name as branch_name'
        )
            ->leftJoin('outlets', 'users.outlet_id', '=', 'outlets.id')
            ->leftJoin('branches', 'outlets.branch_id', '=', 'branches.id')
            ->where('role_id', '=', 4)
            ->where('users.status', '=', "deactive")
            ->where('users.outlet_id', '=', $loggedInUserOutletId)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('users.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%')
                        ->orWhere('outlets.Name', 'like', '%' . $search . '%')
                        ->orWhere('branches.name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('users.status', '=', 'deactive');
            })
            ->when($isActive, function ($query, $isActive) {
                return $query->where('users.isActive', '=', 1);
            })
            ->orderBy('users.' . $sortBy, $sortDirection) // Use dynamic sorting
            ->paginate(10);

        $outlets = Outlet::all();
        return view('manager.CoparateCustomers.index', [
            'users' => $users,
            'outlets' => $outlets,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }
    public function destroy(User $id)
    {
        try {
            $id->update(['isActive' => 0]);
            return response()->json(['success' => 'Customer  deleted successfully!'], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['error' => 'Failed to delete Customer '], 500);
        }
    }
    public function updateCorporateCustomerStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['status' => 'active']);
            $loginUrl = url('/login-view');
          
            Mail::to($user->email)->send(new CoparateCustomerAproval($user, $loginUrl));


            return response()->json(['success' => 'Customer status updated successfully!'], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['error' => 'Failed to update customer status',$e->getMessage()], 500);
        }
    }
    public function Customertokens(Request $request, $userId)
    {
        // Default sort parameters
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');
        $search = $request->get('search');
        $status = $request->get('status');
        $isActive = $request->get('is_active', true);

        // Query tokens for the specific user
        $tokens = Token::select(
            'tokens.id',
            'tokens.status',
            'tokens.isActive',
            'tokens.description',
            'tokens.expires_at',
            'tokens.token_code',
            'users.name as username',
            'gas_cylinders.name as cylinder_name',
            'outlets.Name as outlet_name'
        )
            ->leftJoin('users', 'tokens.user_id', '=', 'users.id')
            ->leftJoin('gas_cylinders', 'tokens.cylinder_type_id', '=', 'gas_cylinders.id')
            ->leftJoin('outlets', 'tokens.outlet_id', '=', 'outlets.id')
            ->where('tokens.user_id', '=', $userId)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('tokens.description', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('gas_cylinders.name', 'like', '%' . $search . '%')
                        ->orWhere('outlets.Name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('tokens.status', '=', $status);
            })
            ->when($isActive, function ($query, $isActive) {
                return $query->where('tokens.isActive', '=', 1);
            })
            ->orderBy('tokens.' . $sortBy, $sortDirection) // Dynamic sorting
            ->paginate(10);

        return view('manager.Customers.tokenHistory', [
            'tokens' => $tokens,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }
    public function TokenHistory(Request $request, $tokenid)
    {

        
        $tokenHistory = TokenHistory::where('token_id', $tokenid)->get();

        if ($tokenHistory->isEmpty()) {
            return response()->json(['message' => 'No token history found.'], 404);
        }

        return response()->json([
            'success' => true,
            'tokenHistory' => $tokenHistory
        ]);

    }

}
