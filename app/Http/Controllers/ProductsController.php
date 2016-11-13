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
        return view('products.show');
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
                    ->leftJoin('itemquantity_instock', 'items.Item_id', '=', 'itemquantity_instock.id_item')
                    ->select('items.item_code as code', 'items.Item_name as item', 'itemcategory.Itemcategory_name as category', 'itemunity.Itemunity_name as unity', 'items.item_price as price', 'itemtype.itemtype_name as type', 'itemvat.itemvat_name as vat', 'items.Item_id as id', 'itemquantity_instock.quantity as quantity')
                    ->where('items.is_product', '1')
                    ->where('items.deleted', '0')
                    ->where(function($query) use ($request){
                        $query->where('items.item_name', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('itemcategory.Itemcategory_name', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('items.item_code', 'like', '%'.$request->search['value'].'%');

                    })
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
                    ->leftJoin('itemquantity_instock', 'items.Item_id', '=', 'itemquantity_instock.id_item')
                    ->select('items.item_code as code', 'items.Item_name as item', 'itemcategory.Itemcategory_name as category', 'itemunity.Itemunity_name as unity', 'items.item_price as price', 'itemtype.itemtype_name as type', 'itemvat.itemvat_name as vat', 'items.Item_id as id', 'itemquantity_instock.quantity as quantity')
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

            $this->sql = "select i.item_code as code, i.Item_name as item,
                          itemcompound.itemcompound_id as id, itemcompound.quantity as quantity
                          FROM items i
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

        DB::transaction(function () use ($item, $data){
           $item->save();
           DB::table('itemquantity_instock')
               ->insert(['id_item'=>$item->Item_id, 'id_stockroom'=>1, 'id_furnisher'=>1, 'quantity'=>$data['item-quantity']]);
        });

        return Redirect::to('/products');
    }

    public function edit(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;
            $response['message'] = "Item edited successfully!";

            //Audit
            $audit = [];
            $audit['updated_table'] = 'items';

            try
            {
                DB::beginTransaction();

                switch($request->name)
                {
                    case "item-code":
                        $item = Item::find($request->pk);
                        $old_value = $item->item_code;
                        $item->update(["item_code" => $request->value]);
                        $audit['updated_field'] = 'item_code';
                        $audit['id_record'] = $item->Item_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->item_code;
                        $audit['updated_description'] = "Item update";
                        break;
                    case "item-name":
                        $item = Item::find($request->pk);
                        $old_value = $item->Item_name;
                        $item->update(["Item_name" => $request->value]);
                        $audit['updated_field'] = 'Item_name';
                        $audit['id_record'] = $item->Item_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->Item_name;
                        $audit['updated_description'] = "Item update";
                        break;
                    case "item-category":
                        $item = Item::find($request->pk);
                        $old_value = $item->id_itemcategory;
                        $item->update(["id_itemcategory" => $request->value]);
                        $audit['updated_field'] = 'id_itemcategory';
                        $audit['id_record'] = $item->Item_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->id_itemcategory;
                        $audit['updated_description'] = "Item update";
                        break;
                    case "item-unity":
                        $item = Item::find($request->pk);
                        $old_value = $item->id_itemunity;
                        $item->update(["id_itemunity" => $request->value]);
                        $audit['updated_field'] = 'id_itemunity';
                        $audit['id_record'] = $item->Item_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->id_itemunity;
                        $audit['updated_description'] = "Item update";
                        break;
                    case "item-price":
                        $item = Item::find($request->pk);
                        $old_value = $item->item_price;
                        $item->update(["item_price" => $request->value]);
                        $audit['updated_field'] = 'item_price';
                        $audit['id_record'] = $item->Item_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->item_price;
                        $audit['updated_description'] = "Item update";
                        break;
                    case "item-type":
                        $item = Item::find($request->pk);
                        $old_value = $item->id_itemtype;
                        $item->update(["id_itemtype" => $request->value]);
                        $audit['updated_field'] = 'id_itemtype';
                        $audit['id_record'] = $item->Item_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->id_itemtype;
                        $audit['updated_description'] = "Item update";
                        break;
                    case "item-vat":
                        $item = Item::find($request->pk);
                        $old_value = $item->id_vat;
                        $item->update(["id_vat" => $request->value]);
                        $audit['updated_field'] = 'id_vat';
                        $audit['id_record'] = $item->Item_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->id_vat;
                        $audit['updated_description'] = "Item update";
                        break;
                }

                MainController::audit($audit);
                DB::commit();
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                $response['status'] = 500;
                $response['message'] = "Editing Failed!";
                return $response;
            }

            return $response;
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;
            $response['message'] = "Product successfully removed!";

            $item = Item::find($request->pk);

            DB::transaction(function () use ($item, $request)
            {
                try
                {
                    $old_value = 0;
                    $item->update(["deleted" => 1]);
                    //Audit
                    $audit = [];
                    $audit['updated_table'] = 'items';
                    $audit['updated_field'] = 'deleted';
                    $audit['id_record'] = $item->Item_id;
                    $audit['old_value'] = $old_value;
                    $audit['new_value'] = $item->deleted;
                    $audit['updated_description'] = "Item delete";
                    MainController::audit($audit);

                    //delete itemcompounds
                    $itemcompounds = DB::table('itemcompound')
                        ->where('id_item_product', $request->pk)
                        ->where('deleted', 0);
                    $recordsItemcompounds = $itemcompounds->get();
                    $itemcompounds->update(['deleted' => 1]);
                    //Itemcompounds Audit
                    $audit['updated_table'] = 'itemcompound';
                    foreach ($recordsItemcompounds as $item)
                    {
                        $audit['id_record'] = $item->itemcompound_id;
                        MainController::audit($audit);
                    }

                    //delete stock
                    $itemsStock = DB::table('itemquantity_instock')
                        ->where('id_item', $request->pk)
                        ->where('deleted', 0);
                    $recordsItemsStock = $itemsStock->get();
                    $itemsStock->update(['deleted' => 1]);
                    //ItemsStock Audit
                    $audit['updated_table'] = 'itemquantity_instock';
                    foreach ($recordsItemsStock as $item)
                    {
                        $audit['id_record'] = $item->Itemquantity_instock_id;
                        MainController::audit($audit);
                    }

                }
                catch(\Exception $e)
                {
                    $response['status'] = 500;
                    $response['message'] = "Product could not be deleted!";
                    return $response;
                }

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
            $response['message'] = 'Raw material successfully removed!';

            $sql = "update itemcompound set deleted = 1 where itemcompound_id = :id";

            try
            {
                DB::beginTransaction();
                DB::update($sql, [":id"=>$request->pk]);
                //Audit
                $audit = [];
                $audit['updated_table'] = 'itemcompound';
                $audit['updated_field'] = 'deleted';
                $audit['id_record'] =$request->pk;
                $audit['old_value'] = 0;
                $audit['new_value'] = 1;
                $audit['updated_description'] = "Item delete";
                MainController::audit($audit);
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                $response['status'] = 500;
                $response['message'] = 'Raw material could not be deleted!';
                return $response;
            }

            DB::commit();
            return $response;
        }
    }

}
