<?php

namespace App\Http\Controllers;

use App\Models\GasCylinder;
use Illuminate\Http\Request;

class GasCylinderController extends Controller
{
    public function index()
    {
        $gasCylinders = GasCylinder::all();
        return view('admin.GasCylinder.index', compact('gasCylinders'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'size' => 'required|numeric',
            'user_price' => 'required|numeric',
            'organization_price' => 'required|numeric',
            'isActive' => 'boolean'
        ]);

        GasCylinder::create($request->all());
        return redirect()->route('gascylinderview')->with('success', 'Gas Cylinder added successfully.');
    }

    public function edit($id)
    {
        $gasCylinder = GasCylinder::findOrFail($id);
        return response()->json($gasCylinder);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'size' => 'required|numeric',
            'user_price' => 'required|numeric',
            'organization_price' => 'required|numeric',
            'isActive' => 'boolean'
        ]);

        $gasCylinder = GasCylinder::findOrFail($id);
        $gasCylinder->update($request->all());

        return redirect()->route('gascylinderview')->with('success', 'Gas Cylinder updated successfully.');
    }

    public function destroy($id)
    {
        $gasCylinder = GasCylinder::findOrFail($id);
        $gasCylinder->delete();
        return redirect()->route('gascylinderview')->with('success', 'Gas Cylinder deleted successfully.');
    }

    public function GetAllGasCylinders(Request $request)
    {
        $outlets = GasCylinder::where('isActive', true)->get(); 
    
        return response()->json($outlets); 
    }
}


