<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public function dashboard_view(){
        return view('admin.admindashboard');
    }
}
