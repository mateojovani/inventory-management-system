<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Entrysheet, App\Furnisher;

class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $furnisher = Furnisher::first();
        $date = date('d-m-Y');

        return view('entrysheet.show')->with(['furnisher'=>$furnisher, 'date'=>$date]);
    }
}
