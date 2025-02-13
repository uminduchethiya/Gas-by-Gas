<?php

namespace App\Http\Controllers;

use App\Consts\UserRoleConst;
use App\Http\Controllers\Controller;
use App\Mail\GasCylinderPriceUpdate;
use App\Models\GasCylinder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        return redirect()->route('admin.gascylinderview')->with('success', 'Gas Cylinder added successfully.');
    }

    public function edit($id)
    {
        $cylinder = GasCylinder::findOrFail($id);
        return response()->json($cylinder);
    }

    public function update(Request $request, $id)
    {
        $cylinder = GasCylinder::find($id);
        
        if (!$cylinder) {
            return redirect()->route('admin.gascylinderview')->with('error', 'Gas Cylinder not found');
        }
    
        $cylinder->update($request->all());
    
        return redirect()->route('admin.gascylinderview')->with('success', 'Gas Cylinder updated successfully');
    }
    
    public function destroy($id)
    {
        $gasCylinder = GasCylinder::findOrFail($id);
        $gasCylinder->delete();
        return redirect()->route('admin.gascylinderview')->with('success', 'Gas Cylinder added successfully.');
    }


    public function GetAllGasCylinders(Request $request)
    {
        $outlets = GasCylinder::where('isActive', true)->get();

        return response()->json($outlets);
    }


    public function sendPriceUpdate()
    {
        // Get all gas cylinders
        $gasCylinders = GasCylinder::all();

        // Get only users with USER or ORGANIZATION role
        $users = User::whereIn('role_id', [UserRoleConst::USER, UserRoleConst::ORGANIZATION])->get();

        // Ensure there are valid users
        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'No eligible users found to send the email.');
        }

        if ($gasCylinders->isEmpty()) {
            return redirect()->back()->with('error', 'No gas cylinder data found.');
        }

        // Send the email to only users with valid roles
        foreach ($users as $user) {
            $filteredCylinders = $gasCylinders->map(function ($cylinder) use ($user) {
                return [
                    'name' => $cylinder->name,
                    'price' => ($user->role_id == UserRoleConst::USER) ? $cylinder->user_price : $cylinder->organization_price,
                ];
            });

            Mail::to($user->email)->send(new GasCylinderPriceUpdate($filteredCylinders, $user->role_id));
        }

        return redirect()->back()->with('success', 'Price update sent to all eligible users.');
    }
}
