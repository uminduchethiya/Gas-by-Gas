<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OutletToken;

use App\Models\GasCylinder;
use App\Models\Outlet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletTokenController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');
        $isActive = $request->input('isActive');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $outletTokens = OutletToken::select(
            'outlet_tokens.id',
            'outlet_tokens.maxTokens',
            'outlet_tokens.gas_cylinder_id',
            'outlet_tokens.currentTokens',
            'outlet_tokens.token_amount',
            'outlet_tokens.created_at',
            'outlets.name as branch_name',
            'outlets.OutletID as OutletID',

            'gas_cylinders.name as gas_cylinder_name'
        )
            ->leftJoin('outlets', 'outlet_tokens.OutletID', '=', 'outlets.OutletID')
            ->leftJoin('gas_cylinders', 'outlet_tokens.gas_cylinder_id', '=', 'gas_cylinders.id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('outlet_tokens.token_amount', 'like', '%' . $search . '%')
                        ->orWhere('outlets.name', 'like', '%' . $search . '%')
                        ->orWhere('gas_cylinders.name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('outlet_tokens.status', '=', $status);
            })
            ->when($isActive, function ($query, $isActive) {
                return $query->where('outlet_tokens.isActive', '=', $isActive);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);



        $outlets = Outlet::all();
        $gasCylinders = GasCylinder::all();

        // Return the view with the necessary data
        return view('admin.OutletToken.index', [
            'outletTokens' => $outletTokens,
            'outlets' => $outlets,
            'gasCylinders' => $gasCylinders,
        ]);
    }
    public function store(Request $request)
    {
        // Validate the form data

        $validated = $request->validate([
            'outlet_id' => 'required|exists:outlets,OutletID',
            'gas_cylinder_id' => 'required|exists:gas_cylinders,id',
            'token_amount' => 'required|numeric',
        ]);
        $existingToken = OutletToken::where('OutletID', $request->outlet_id)
            ->where('gas_cylinder_id', $request->gas_cylinder_id)
            ->where('gas_cylinder_id', $request->gas_cylinder_id)

            ->first();

        if ($existingToken) {

            return response()->json(['error' => 'This outlet already has this type of gas cylinder.'], 400);
        }


        // Save the data
        OutletToken::create([
            'OutletID' => $request->input('outlet_id'),
            'gas_cylinder_id' => $request->input('gas_cylinder_id'),
            'token_amount' => $request->token_amount,
            'maxTokens' => $request->token_amount,
            'currentTokens' => $request->token_amount,
            'status' => 'active',
        ]);

        // Return success message
        return response()->json(['success' => 'Outlet Token created successfully!']);
    }
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'token_amount' => 'required|numeric',
                'maxTokens' => 'required|numeric',
            ]);

            $outlet = OutletToken::findOrFail($id);
            $outlet->update($validated);

            return response()->json(['success' => 'Outlet updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function destroy(OutletToken $outlet)
    {
        try {
            $outlet->delete();
            return response()->json(['message' => 'Outlet deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete outlet.'], 500);
        }
    }
}
