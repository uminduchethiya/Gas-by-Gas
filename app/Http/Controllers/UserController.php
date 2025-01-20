<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home_view(){
        return view('user.home');
    }

    public function aboutus_view(){
        return view('user.aboutus');
    }

    public function countacus_view(){
        return view('user.contactus');
    }

    
}
