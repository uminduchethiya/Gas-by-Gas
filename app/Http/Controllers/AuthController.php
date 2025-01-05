<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginView(){
        return view('auth.login');
    }
    public function register(){
        return view('auth.register');
    }
}
