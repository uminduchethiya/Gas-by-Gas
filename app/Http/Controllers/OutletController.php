<?php

namespace App\Http\Controllers;

use App\Models\Branch;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\outlet;
use App\Models\OutletToken;
use App\Models\GasCylinder;

use App\Consts\UserRoleConst;
use Illuminate\Support\Facades\Mail;
use App\Mail\OutletCreated;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{

    public function index(Request $request)
    {
        // Default sort parameters
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');

        $search = $request->get('search');
        $status = $request->get('status');
        $isActive = $request->get('is_active', true);

        $outlets = Outlet::select(
            'outlets.id',
            'outlets.Name',
            'outlets.Address',
            'outlets.ContactNumber',
            'outlets.Email',
            'outlets.Latitude',
            'outlets.Longitude',
            'outlets.isActive',
            'branches.name as branch_name',
            'branches.id as branch_id',
            'users.name as user_name'
        )
            ->leftJoin('branches', 'outlets.branch_id', '=', 'branches.id')
            ->leftJoin('users', 'outlets.user_id', '=', 'users.id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('outlets.Name', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('branches.name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('outlets.isActive', '=', $status);
            })
            ->when($isActive, function ($query, $isActive) {
                return $query->where('outlets.isActive', '=', $isActive);
            })
            ->orderBy('outlets.' . $sortBy, $sortDirection) // Use the dynamic sorting
            ->paginate(10);


        $branches = Branch::all();

        return view('admin.outlet.index', [
            'outlets' => $outlets,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'branches' => $branches,

        ]);
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); // Start the transaction

            $validated = $request->validate([
                'branch_id' => 'required|exists:branches,id',
                'Name' => 'required|string|max:255',
                'Address' => 'required|string',
                'ContactNumber' => 'required|string|max:15',
                'Email' => 'nullable|email|unique:users,email',
                'isActive' => 'required',
            ]);
            $loginUrl = url('/login-view'); // URL to the login page
            $isActive = ($validated['isActive'] === 'Active') ? 1 : 0;

            $outlet = Outlet::create([
                'name' => $validated['Name'],
                'address' => $validated['Address'],
                'ContactNumber' => $validated['ContactNumber'],
                'email' => $request->Email,
                'isActive' => $isActive,
                'branch_id' => $validated['branch_id'],
                'UserID' => null,
            ]);


            $user = null;
            if ($validated['Email']) {
                $user = User::create([
                    'name' => $request->Name,
                    'email' => $request->Email,
                    'password' => bcrypt(config('app.USER_DEFAULT_PASSWORD')),
                    'contact_number' => $request->ContactNumber,
                    'address' => $request->Address,
                    'role_id' => UserRoleConst::MANAGER,
                    'outlet_id' => $outlet->id,
                ]);
                Mail::to($user->email)->send(new OutletCreated($user, $loginUrl));
            }

            $outlet->update([
                'UserID' => $user->id,
            ]);

            DB::commit(); // Commit the transaction
            return response()->json(['success' => 'Outlet created successfully!']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function destroy(Outlet $outlet)
    {
        try {
            $outlet->update(['Status' => 'Inactive']);

            return response()->json(['message' => 'Outlet deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete outlet.'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'branch_id' => 'required|exists:branches,id',
                'Name' => 'required|string|max:255',
                'Address' => 'required|string',
                'ContactNumber' => 'required|string|max:15',
                'Email' => 'nullable|email|unique:users,email,' . $id,
                'isActive' => 'required|in:Active,Inactive',
            ]);
            $validated['isActive'] = ($validated['isActive'] === 'Active') ? 1 : 0;
            $outlet = Outlet::findOrFail($id);
            $outlet->update($validated);

            return response()->json(['success' => 'Outlet updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($outletId)
    {
        try {
            $outlet = Outlet::with(['outletTokens.gasCylinder'])  // Eager load outletTokens and their related gasCylinder
            ->findOrFail($outletId);
            $outletData = [
                'Name' => $outlet->Name,
                'Address' => $outlet->Address,
                'ContactNumber' => $outlet->ContactNumber,
                'Status' => $outlet->Status,
                'Tokens' => $outlet->outletTokens->map(function ($token) {
                    return [
                        'gas_cylinder_name' => $token->gasCylinder->name,
                        'currentTokens' => $token->currentTokens,
                        'maxTokens' => $token->maxTokens,
                        'token_amount' => $token->token_amount
                    ];
                })
            ];


            return response()->json(['success' => true, 'outlet' => $outletData]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

}
