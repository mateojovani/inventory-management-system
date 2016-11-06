<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, \DB, App\Item, \Redirect;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getItems()
    {
        $items = [['value' => 0, 'text' => 'Raw Material'],['value' => 1, 'text' => 'Product']];

        return json_encode($items);
    }

    public function show()
    {
        return view('config.show');
    }

    public function showCatGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = DB::table('itemcategory')->where('deleted', '0')->count();

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'category';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'item';

                $dir = $request->order[0]['dir'];
            }
            else
            {
                $orderBy = '';
                $dir = 'desc';
            }

            $items = DB::table('itemcategory')
                ->select('itemcategory.Itemcategory_name as category', 'itemcategory.is_for_product as item', 'itemcategory.Itemcategory_id as id')
                ->where('itemcategory.deleted', '0')
                ->orderBy($orderBy, $dir)
                ->get();


            $json_data = array(
                "draw"            => $request->draw,
                "recordsTotal"    => $records,
                "recordsFiltered" => $records,
                "data"            => $items
            );
            return $json_data;

        }
    }

    public function deleteCategory(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;

            DB::transaction(function () use ($request)
            {
                DB::table('itemcategory')
                    ->where('Itemcategory_id', $request->pk)
                    ->update(['deleted' => 1]);
            });

            return $response;
        }
    }

    public function addCategory(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;

            DB::transaction(function () use ($request)
            {
                DB::table('itemcategory')
                    ->insert(['Itemcategory_name' => $request->name, 'is_for_product' => $request->type, 'id_itemcategory' => 0]);
            });

            return $response;
        }
    }

    public function editCategory(Request $request)
    {
        if($request->ajax())
        {
            switch($request->name)
            {
                case "category":
                    DB::table('itemcategory')
                        ->where('Itemcategory_id', $request->pk)
                        ->update(["Itemcategory_name" => $request->value]);
                    break;
                case "name":
                    DB::table('itemcategory')
                        ->where('Itemcategory_id', $request->pk)
                        ->update(["is_for_product" => $request->value]);
                    break;
            }
        }
    }

}
