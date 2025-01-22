<?php

namespace App\Http\Controllers;

use App\Models\GasCylinder;
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
            ->with(['gasCylinder', 'branch'])
            ->paginate(10);

        return view('manager.stock.index', compact('stocks', 'gasCylinders'));
    }

}
