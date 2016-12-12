<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \App, \Crypt;

class Controller extends BaseController
{
    public $lang;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}
