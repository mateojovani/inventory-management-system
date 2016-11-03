<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class MainController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showHome()
    {
        return view('home');
    }

}
