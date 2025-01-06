<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerDashboard extends Controller
{
    public function dashboard_view(){
        return view('manager.layout');
    }
    public function index()
    {
        return view('manager.ManagerDashboard');
    }
}
