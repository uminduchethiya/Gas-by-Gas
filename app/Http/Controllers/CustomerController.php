<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\User;
use App\Models\GasCylinder;


use App\Models\TokenHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->where('role_id', '=', 3)
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

            return response()->json(['success' => 'Customer status updated successfully!'], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['error' => 'Failed to update customer status'], 500);
        }
    }

}
