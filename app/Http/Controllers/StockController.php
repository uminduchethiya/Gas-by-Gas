<?php

namespace App\Http\Controllers;

use App\Models\GasCylinder;
use App\Models\Outlet;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        $loggedInUserOutletId = auth()->user()->outlet_id;
        $gasCylinders = GasCylinder::where('isActive', true)->get();

        $stocks = Stock::query()
            ->where('outlet_id', $loggedInUserOutletId)
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('gasCylinder', function ($subQuery) use ($request) {
                    $subQuery->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->gas_cylinder_id, function ($query) use ($request) {
                $query->where('gas_cylinder_id', $request->gas_cylinder_id);
            })
            ->with(['gasCylinder', 'outlet'])
            ->paginate(10);

        return view('manager.stock.index', compact('stocks', 'gasCylinders'));
    }
    public function adminIndex(Request $request)
    {
        $currentUser = auth()->user();
        $loggedInUserOutletId = auth()->user()->outlet_id;
        $gasCylinders = GasCylinder::where('isActive', true)->get();
        $outlets = Outlet::get();

        $stocks = Stock::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('gasCylinder', function ($subQuery) use ($request) {
                    $subQuery->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->outlet_id, function ($query) use ($request) {
                $query->where('outlet_id', $request->outlet_id);
            })
            ->when($request->gas_cylinder_id, function ($query) use ($request) {
                $query->where('gas_cylinder_id', $request->gas_cylinder_id);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('isActive', $request->status == '1' ? true : false);
            })
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            ->with(['gasCylinder', 'outlet'])
            ->paginate(10);

        return view('admin.Stock.index', compact('stocks', 'gasCylinders', 'outlets'));
    }

}
