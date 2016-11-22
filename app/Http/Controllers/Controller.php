<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \App;

class Controller extends BaseController
{
    public $lang;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //\Cookie::queue('lang', 'sq', 60*24);
        $lang = \Crypt::decrypt(\Cookie::get('lang'));
        if ($lang != null) App::setLocale($lang);
        $this->lang = App::getLocale();
    }


}
