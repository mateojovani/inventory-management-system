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
            $productLeft = [];
            $itemsArr = [];

            $sql = "select i.Item_id as id, itemcompound.quantity as icq, itemquantity_instock.quantity as isq
                          FROM items i
                          join itemcompound on itemcompound.id_item_rawmaterial = i.Item_id and itemcompound.deleted = 0
                          join itemquantity_instock on itemquantity_instock.id_item = i.Item_id and itemquantity_instock.deleted = 0
                          where itemcompound.id_item_product = :id";

            $thisProductItems = DB::select($sql, [":id"=>$request->id]);

            //if any products
            $products = $request->products;
            if(!empty($products))
            foreach ($products as $product)
            {
                $items = DB::select($sql, [":id"=>$product['id']]);

                foreach ($items as $item)
                {
                    if(empty($itemsArr[$item->id]))
                        $itemsArr[$item->id] = $item->isq;

                    $quantityLeft = $itemsArr[$item->id] - (intval($product['quantity'])*$item->icq);
                    $itemsArr[$item->id] = $quantityLeft;
                }

            }

            foreach ($thisProductItems as $item)
            {
                if(empty($itemsArr[$item->id]))
                    $itemsArr[$item->id] = $item->isq;

                $left = intval($itemsArr[$item->id]/$item->icq);
                if($left < 1)
                    return -1;

                $productLeft[] = $left;
            }

            return min($productLeft);

        }

    }


}
