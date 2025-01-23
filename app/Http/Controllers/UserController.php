<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GasCylinder;
use App\Models\Outlet;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home_view(){
        $outlets = Outlet::all();
        $user = auth()->user();
        $gasCylinders = GasCylinder::where('isActive', true)->get();
        $loggedInUserId = auth()->id();
        $assignedOutletId = auth()->user()->outlet_id;
        $assignedStatus = auth()->user()->role_id;

        return view('user.home', compact('outlets', 'assignedOutletId', 'gasCylinders', 'loggedInUserId', 'assignedStatus'));
    }

    public function aboutus_view(){
        return view('user.aboutus');
    }

    public function countacus_view(){

        return view('user.contactus');
    }

}
