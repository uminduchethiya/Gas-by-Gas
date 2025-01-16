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
        $sortBy = $request->get('sort_by', 'OutletID');
        $sortDirection = $request->get('sort_direction', 'asc');

        $search = $request->get('search');
        $status = $request->get('status');
        $isActive = $request->get('is_active', 'Active');

        $outlets = Outlet::select(
            'outlets.OutletID',
            'outlets.Name',
            'outlets.Address',
            'outlets.ContactNumber',
            'outlets.Email',
            'outlets.Latitude',
            'outlets.Longitude',
            'outlets.Status',
            'branches.name as branch_name',
            'branches.id as branch_id',
            'users.name as user_name'
        )
            ->leftJoin('branches', 'outlets.branch_id', '=', 'branches.id')
            ->leftJoin('users', 'outlets.UserID', '=', 'users.id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('outlets.Name', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('branches.name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('outlets.Status', '=', $status);
            })
            ->when($isActive, function ($query, $isActive) {
                return $query->where('outlets.Status', '=', $isActive);
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
                'Status' => 'required|in:Active,Inactive',
            ]);
            $loginUrl = url('/login-view'); // URL to the login page

            $user = null;
            if ($validated['Email']) {
                $user = User::create([
                    'name' => $request->Name,
                    'email' => $request->Email,
                    'password' => bcrypt(config('app.USER_DEFAULT_PASSWORD')),
                    'contact_number' => $request->ContactNumber,
                    'address' => $request->Address,
                    'role_id' => UserRoleConst::MANAGER,
                    'branch_id' => $request->branch_id,
                ]);
                Mail::to($user->email)->send(new OutletCreated($user, $loginUrl));
            }

            $outlet = Outlet::create([
                'branch_id' => $validated['branch_id'],
                'UserID' => $user->id ?? null,
                'Email' => $request->Email,
                'Name' => $validated['Name'],
                'Address' => $validated['Address'],
                'ContactNumber' => $validated['ContactNumber'],
                'Status' => $validated['Status'],
            ]);

            $activeGasCylinders = GasCylinder::where('isActive', true)->get();

            foreach ($activeGasCylinders as $cylinder) {
                OutletToken::create([
                    'OutletID' => $outlet->OutletID,
                    'gas_cylinder_id' => $cylinder->id,
                    'maxTokens' => config('tokens.DEFAULT_TOKEN_LIMIT', 100),
                    'currentTokens' => config('tokens.DEFAULT_TOKEN_LIMIT', 100),
                    'token_amount' => config('tokens.DEFAULT_TOKEN_LIMIT', 100),
                ]);
            }

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
                'Status' => 'required|in:Active,Inactive',
            ]);

            $outlet = Outlet::findOrFail($id);
            $outlet->update($validated);

            return response()->json(['success' => 'Outlet updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $outlet = Outlet::with(['branchTokens.gasCylinder'])  // Eager load outlet tokens and gas cylinders
                ->findOrFail($id);

            $outletData = [
                'Name' => $outlet->Name,
                'Address' => $outlet->Address,
                'ContactNumber' => $outlet->ContactNumber,
                'Status' => $outlet->Status,
                'Tokens' => $outlet->branchTokens->map(function ($token) {
                    return [
                        'gas_cylinder_name' => $token->gasCylinder->name,  // Assuming 'name' column exists in GasCylinder
                        'currentTokens' => $token->currentTokens,
                        'maxTokens' => $token->maxTokens,
                        'token_amount' => $token->token_amount
                    ];
                })
            ];
            

            return response()->json(['success' => true, 'outlet' => $outletData]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Outlet not found'], 404);
        }
    }

}
