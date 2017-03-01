<?php

namespace App\Http\Controllers;

use \Auth, \DB;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Outputsheet, App\Datasheet, App\Client;

class OutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $client = Client::first();
        $date = date('d-m-Y');
        $serial = intval(microtime(true));

        return view('outputsheet.show')->with(['client'=>$client, 'date'=>$date, 'serial'=>$serial]);
    }

    public function control(Request $request)
    {
        if($request->ajax())
        {
            $product_id = $request->id;

            $sql = "select i.Item_id as id, itemcompound.quantity as icq, itemquantity_instock.quantity as isq
                          FROM items i
                          join itemcompound on itemcompound.id_item_rawmaterial = i.Item_id and itemcompound.deleted = 0
                          join itemquantity_instock on itemquantity_instock.id_item = i.Item_id and itemquantity_instock.deleted = 0
                          where itemcompound.id_item_product = :id";


            $items = DB::select($sql, [":id"=>$product_id]);

            $productLeft = [];
            foreach ($items as $item)
            {
                if($item->icq > $item->isq)
                    return -1;
                else
                {
                    $productLeft[] = intval($item->isq/$item->icq);
                }
            }

            return min($productLeft);
        }

    }


}
