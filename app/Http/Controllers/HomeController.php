<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(){
        $role = Auth::user()->role;

        if ($role == 0){
            return view('dashboard.admin');
        }else{
            return view('dashboard.member');

        }
    }


}
