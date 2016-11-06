<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, \DB, App\Item, \Redirect;

class ProductsController extends Controller
{
    private $sql;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $data = [];
        $data['categories'] = RawMaterialsController::getCategories();
        $data['unities'] = RawMaterialsController::getUnities();
        $data['itemtypes'] = RawMaterialsController::getTypes();
        $data['itemvats'] = RawMaterialsController::getVat();

        return view('products.show')->with($data);
    }

    public function getCategories()
    {
        $this->sql = 'select Itemcategory_name as text, Itemcategory_id as value from itemcategory
                      where is_for_product = 1 and deleted = 0';
        $categories = DB::select($this->sql);

        return $categories;
    }

    public function getUnities()
    {
        $this->sql = 'select Itemunity_name as text, Itemunity_id as value from itemunity
                      where is_for_product = 1 and deleted = 0';
        $unities = DB::select($this->sql);

        return $unities;
    }

    public function getTypes()
    {
        $this->sql = 'select itemtype_name as text, itemtype_id as value from itemtype
                      where is_for_product = 1 and deleted = 0';
        $itemtypes = DB::select($this->sql);

        return $itemtypes;
    }

    public function getVat()
    {
        $this->sql = 'select itemvat_name as text, itemvat_id as value from itemvat
                      where deleted = 0';
        $itemvats = DB::select($this->sql);

        return $itemvats;
    }

    public function showGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = Item::where('is_product', '1')->where('deleted', '0')->count();

            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'code';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'item';
                else if($request->order[0]['column'] == '2')
                    $orderBy = 'category';
                else if($request->order[0]['column'] == '3')
                    $orderBy = 'unity';
                else if($request->order[0]['column'] == '4')
                    $orderBy = 'price';
                else if($request->order[0]['column'] == '5')
                    $orderBy = 'type';
                else if($request->order[0]['column'] == '6')
                    $orderBy = 'vat';
                else $orderBy = '';

                $dir = $request->order[0]['dir'];
            }
            else
            {
                $orderBy = '';
                $dir = 'desc';
            }

            #server search
            if($request->search['value'] != '')
            {
                $items = DB::table('items')
                    ->leftJoin('itemcategory', 'items.id_itemcategory', '=', 'itemcategory.Itemcategory_id')
                    ->leftJoin('itemunity', 'items.id_itemunity', '=', 'itemunity.Itemunity_id')
                    ->leftJoin('itemtype', 'items.id_itemtype', '=', 'itemtype.itemtype_id')
                    ->leftJoin('itemvat', 'items.id_vat', '=', 'itemvat.itemvat_id')
                    ->select('items.item_code as code', 'items.Item_name as item', 'itemcategory.Itemcategory_name as category', 'itemunity.Itemunity_name as unity', 'items.item_price as price', 'itemtype.itemtype_name as type', 'itemvat.itemvat_name as vat', 'items.Item_id as id')
                    ->where('items.is_product', '1')
                    ->where('items.deleted', '0')
                    ->where('items.item_name', 'like', '%'.$request->search['value'].'%')
                    ->orWhere('itemcategory.Itemcategory_name', 'like', '%'.$request->search['value'].'%')
                    ->offset($start)->limit($length+$start)
                    ->orderBy($orderBy, $dir)
                    ->get();
                $records = $items->count();
            }
            else
            {
                $items = DB::table('items')
                    ->leftJoin('itemcategory', 'items.id_itemcategory', '=', 'itemcategory.Itemcategory_id')
                    ->leftJoin('itemunity', 'items.id_itemunity', '=', 'itemunity.Itemunity_id')
                    ->leftJoin('itemtype', 'items.id_itemtype', '=', 'itemtype.itemtype_id')
                    ->leftJoin('itemvat', 'items.id_vat', '=', 'itemvat.itemvat_id')
                    ->select('items.item_code as code', 'items.Item_name as item', 'itemcategory.Itemcategory_name as category', 'itemunity.Itemunity_name as unity', 'items.item_price as price', 'itemtype.itemtype_name as type', 'itemvat.itemvat_name as vat', 'items.Item_id as id')
                    ->where('items.is_product', '1')
                    ->where('items.deleted', '0')
                    ->offset($start)->limit($length+$start)
                    ->orderBy($orderBy, $dir)
                    ->get();
            }

            $json_data = array(
                "draw"            => $request->draw,
                "recordsTotal"    => $records,
                "recordsFiltered" => $records,
                "data"            => $items
            );
            return $json_data;

        }
    }

    public function showGridForProduct(Request $request)
    {
        if($request->ajax())
        {
            $product_id = $request->id;
            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'code';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'item';
                else if($request->order[0]['column'] == '2')
                    $orderBy = 'category';
                else if($request->order[0]['column'] == '3')
                    $orderBy = 'unity';
                else if($request->order[0]['column'] == '4')
                    $orderBy = 'price';
                else if($request->order[0]['column'] == '5')
                    $orderBy = 'type';
                else if($request->order[0]['column'] == '6')
                    $orderBy = 'vat';
                else if($request->order[0]['column'] == '7')
                    $orderBy = 'quantity';
                else $orderBy = '';

                $dir = $request->order[0]['dir'];
                $order = $orderBy." ".$dir;
                //print_r($order);
            }
            else
            {
                $order = '';
            }

            $this->sql = "select i.item_code as code, i.Item_name as item, ic.Itemcategory_name as category, 
                          iu.Itemunity_name as unity, i.item_price as price, it.itemtype_name as type, iv.itemvat_name as vat,
                          itemcompound.itemcompund_id as id, itemcompound.quantity as quantity
                          FROM items i
                          join itemcategory ic on ic.Itemcategory_id=i.id_itemcategory
                          join itemunity iu on iu.Itemunity_id=i.id_itemunity
                          join itemtype it on it.itemtype_id=i.id_itemtype
                          join itemvat iv on iv.itemvat_id= i.id_vat
                          join itemcompound on itemcompound.id_item_rawmaterial = i.Item_id and itemcompound.deleted = 0
                          where itemcompound.id_item_product = :id
                          order by $order";


            $items = DB::select($this->sql, [":id"=>$product_id]);
            $records = count($items);


            $json_data = array(
                "draw"            => $request->draw,
                "recordsTotal"    => $records,
                "recordsFiltered" => $records,
                "data"            => $items
            );
            return $json_data;

        }
    }

    public function showAdd()
    {
        $data = [];
        $data['categories'] = $this->getCategories();
        $data['unities'] = $this->getUnities();
        $data['itemtypes'] = $this->getTypes();
        $data['itemvats'] = $this->getVat();

        return view('products.add')->with($data);
    }

    public function postAdd(Request $request)
    {
        $data = $request->all();
        $item = new Item();
        $item->item_code = $data['item-code'];
        $item->Item_name = $data['item-name'];
        $item->id_itemcategory = $data['item-category'];
        $item->id_itemunity = $data['item-unity'];
        $item->item_price = $data['item-price'];
        $item->id_vat = $data['item-vat'];
        $item->id_itemtype = $data['item-type'];
        $item->deleted = 0;
        $item->is_product = 1;

        DB::transaction(function () use ($item){
           $item->save();
        });

        return Redirect::to('/products');
    }

    public function edit(Request $request)
    {
        if($request->ajax())
        {
            switch($request->name)
            {
                case "item-code":
                    $item = Item::find($request->pk);
                    $item->update(["item_code" => $request->value]);
                    break;
                case "item-name":
                    $item = Item::find($request->pk);
                    $item->update(["Item_name" => $request->value]);
                    break;
                case "item-category":
                    $item = Item::find($request->pk);
                    $item->update(["id_itemcategory" => $request->value]);
                    break;
                case "item-unity":
                    $item = Item::find($request->pk);
                    $item->update(["id_itemunity" => $request->value]);
                    break;
                case "item-price":
                    $item = Item::find($request->pk);
                    $item->update(["item_price" => $request->value]);
                    break;
                case "item-type":
                    $item = Item::find($request->pk);
                    $item->update(["id_itemtype" => $request->value]);
                    break;
                case "item-vat":
                    $item = Item::find($request->pk);
                    $item->update(["id_vat" => $request->value]);
                    break;
            }
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;
            $item = Item::find($request->pk);

            DB::transaction(function () use ($item, $request){
                $item->update(["deleted" => 1]);
                DB::table('itemcompound')
                    ->where('id_item_product', $request->pk)
                    ->update(['deleted' => 1]);
            });

            return $response;
        }
    }

    public function deleteRawMaterials(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;

            $sql = "update itemcompound set deleted = 1 where itemcompund_id = :id";

            DB::transaction(function () use ($sql, $request){
                DB::update($sql, [":id"=>$request->pk]);
            });

            return $response;
        }
    }

}
