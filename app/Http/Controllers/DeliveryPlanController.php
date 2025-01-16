<?php

namespace App\Http\Controllers;

use App\Models\Branch;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DeliveryPlan;
use App\Models\OutletToken;
use App\Models\GasCylinder;

use App\Consts\UserRoleConst;
use Illuminate\Support\Facades\Mail;
use App\Mail\OutletCreated;
use Illuminate\Support\Facades\DB;

class DeliveryPlanController extends Controller
{

    public function index(Request $request)
    {
        // Default sort parameters
        $sortBy = $request->get('sort_by', 'DeliveryDate');
        $sortDirection = $request->get('sort_direction', 'asc');

        $search = $request->get('search');
        $status = $request->get('status');
        $isActive = $request->get('is_active', 1);
        $deliveryPlans = DeliveryPlan::select(
            'delivery_plans.id',
            'delivery_plans.DeliveryDate',
            'delivery_plans.QuantityPlanned',
            'delivery_plans.QuantityReceived',
            'delivery_plans.Status',
            'delivery_plans.Notes',
            'outlets.Name as outlet_name',
            'gas_cylinders.name as gas_cylinder_name'
        )
            ->leftJoin('outlets', 'delivery_plans.OutletID', '=', 'outlets.OutletID')
            ->leftJoin('gas_cylinders', 'delivery_plans.gas_cylinder_id', '=', 'gas_cylinders.id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('outlets.Name', 'like', '%' . $search . '%')
                        ->orWhere('gas_cylinders.name', 'like', '%' . $search . '%');
                });
            })
            // ->when($status, function ($query, $status) {
            //     return $query->where('delivery_plans.Status', '=', $status);
            // })
            ->where('delivery_plans.isActive', '=', $isActive)  // This will apply the filter with default as 0
            ->orderBy('delivery_plans.' . $sortBy, $sortDirection)
            ->paginate(10);

        $gasCylinders = GasCylinder::all();
        $outlets = Outlet::all();


        return view('admin.DeliveryPlan.index', [
            'deliveryPlans' => $deliveryPlans,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'gasCylinders' => $gasCylinders,
            'outlets' => $outlets
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'DeliveryDate' => 'required|date|after_or_equal:today',
                'QuantityPlanned' => 'required|integer|min:1',
                'Status' => 'required',
                'OutletID' => 'required|exists:outlets,OutletID',
                'gas_cylinder_id' => 'required|exists:gas_cylinders,id',
            ]);


            DeliveryPlan::create($validatedData);

            return response()->json(['success' => 'DeliveryPlan created successfully!']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function destroy(DeliveryPlan $deliveryPlanID)
    {
        try {


            $deliveryPlanID->update(['isActive' => false]);
            return response()->json(['success' => 'Delivery plan deleted successfully!'], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['error' => 'Failed to delete delivery plan.'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'QuantityPlanned' => 'required|numeric|min:1',
            'DeliveryDate' => 'required|date|after_or_equal:today',
            'Status' => 'required|string',
        ]);

        try {
            $deliveryPlan = DeliveryPlan::findOrFail($id);

            $deliveryPlan->QuantityPlanned = $request->QuantityPlanned;
            $deliveryPlan->DeliveryDate = $request->DeliveryDate;
            $deliveryPlan->Status = $request->Status;

            $deliveryPlan->save();

            return response()->json(['success' => 'DeliveryPlan updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function indexManager(Request $request)
    {
        $sortBy = $request->get('sort_by', 'DeliveryDate');
        $sortDirection = $request->get('sort_direction', 'asc');

        $search = $request->get('search');
        $status = $request->get('status');
        $isActive = $request->get('is_active', 1);

        $user = auth()->user();

        // Retrieve outlet IDs associated with the logged-in user
        $userOutletIds = $user->outlets()->pluck('OutletID')->toArray();


        $deliveryPlans = DeliveryPlan::select(
            'delivery_plans.id',
            'delivery_plans.DeliveryDate',
            'delivery_plans.QuantityPlanned',
            'delivery_plans.QuantityReceived',
            'delivery_plans.Status',
            'delivery_plans.Notes',
            'outlets.Name as outlet_name',
            'gas_cylinders.name as gas_cylinder_name'
        )
            ->leftJoin('outlets', 'delivery_plans.OutletID', '=', 'outlets.OutletID')
            ->leftJoin('gas_cylinders', 'delivery_plans.gas_cylinder_id', '=', 'gas_cylinders.id')
            ->where('outlets.OutletID', $userOutletIds) // Filter by the logged-in user's OutletID
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('outlets.Name', 'like', '%' . $search . '%')
                        ->orWhere('gas_cylinders.name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('delivery_plans.Status', '=', $status);
            })
            ->where('delivery_plans.isActive', '=', $isActive)  // This will apply the filter with default as 0
            ->orderBy('delivery_plans.' . $sortBy, $sortDirection)
            ->paginate(10);

        $gasCylinders = GasCylinder::all();
        $outlets = Outlet::all();


        return view('manager.DeliveryPlan.index', [
            'deliveryPlans' => $deliveryPlans,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'gasCylinders' => $gasCylinders,
            'outlets' => $outlets
        ]);
    }
    public function updateManager(Request $request, $id)
    {
        $request->validate([
            'Status' => 'required|string',
            'QuantityReceived' => 'required|string',

        ]);
        try {
            $deliveryPlan = DeliveryPlan::findOrFail($id);


            $deliveryPlan->Notes = $request->Notes;
            $deliveryPlan->Status = $request->Status;

            $deliveryPlan->save();

            return response()->json(['success' => 'DeliveryPlan updated successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
