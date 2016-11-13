<?php

namespace App\Http\Controllers;

use App\Http\Requests, App\Audit, \DB, App\Item;
use Illuminate\Support\Facades\Auth;

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

    public static function audit($infoArr)
    {
        $audit = new Audit();
        $audit->updated_table = $infoArr['updated_table'];
        $audit->updated_field = $infoArr['updated_field'];
        $audit->id_record = $infoArr['id_record'];
        $audit->id_user = Auth::user()->User_id;
        $audit->updated_date = date('Y-m-d H:i:s');
        $audit->old_value = $infoArr['old_value'];
        $audit->new_value = $infoArr['new_value'];
        $audit->updated_description = $infoArr['updated_description'];
        $audit->save();
    }

    public static function checkRestrictions($id, $table)
    {
        //category restrictions | influence on items
        switch ($table)
        {
            case 'itemcategory':
                $items = Item::where('id_itemcategory', $id)
                    ->where('deleted', 0)
                    ->count();
                if($items > 0)
                    return true;
                break;
        }

        return false;
    }

}
