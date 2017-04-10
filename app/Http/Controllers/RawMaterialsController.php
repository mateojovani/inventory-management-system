<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, \DB, App\Item, \Redirect, \Validator;


class RawMaterialsController extends Controller
{

    #custom error messages

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('rawMaterials.show');
    }

    public function validationResponse()
    {
         $messages = [
            'required' => getResponse(500, 'required')['message'],
            'digits_between' => getResponse(500, 'digits_between')['message'],
        ];

        return $messages;
    }

    public static function getCategories()
    {
        $sql = 'select Itemcategory_name as text, Itemcategory_id as value from itemcategory
                      where is_for_product = 0 and deleted = 0';
        $categories = DB::select($sql);

        return $categories;
    }

    public static function getUnities()
    {
        $sql = 'select Itemunity_name as text, Itemunity_id as value from itemunity
                      where is_for_product = 0 and deleted = 0';
        $unities = DB::select($sql);
        
        return $unities;
    }

    public static function getTypes()
    {
        $sql = 'select itemtype_name as text, itemtype_id as value from itemtype
                      where is_for_product = 0 and deleted = 0';
        $itemtypes = DB::select($sql);

        return $itemtypes;
    }

    public static function getVat()
    {
        $sql = 'select itemvat_name as text, itemvat_id as value from itemvat
                      where deleted = 0';
        $itemvats = DB::select($sql);

        return $itemvats;
    }

    public function showGrid(Request $request)
    {
        if($request->ajax())
        {
            //show partial grid
            if($request->has('selected'))
                $unWantedKeys = explode(',', $request->selected);
            else $unWantedKeys = [];

            $records = Item::where('is_product', '0')->where('deleted', '0')->whereNotIn('Item_id', $unWantedKeys)->count();

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
                    ->select('items.item_code as code', 'items.Item_name as item', 'itemcategory.Itemcategory_name as category', 'itemunity.Itemunity_name as unity', 'items.item_price as price', 'itemtype.itemtype_name as type', 'itemvat.itemvat_name as vat', 'itemvat.vat_value as vatValue', 'items.Item_id as id', 'itemquantity_instock.quantity as quantity')
                    ->where('items.is_product', '0')
                    ->where('items.deleted', '0')
                    ->where(function($query) use ($request){
                        $query->where('items.item_name', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('itemcategory.Itemcategory_name', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('items.item_code', 'like', '%'.$request->search['value'].'%');
                    })
                    ->whereNotIn('Item_id', $unWantedKeys)
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
                    ->select('items.item_code as code', 'items.Item_name as item', 'itemcategory.Itemcategory_name as category', 'itemunity.Itemunity_name as unity', 'items.item_price as price', 'itemtype.itemtype_name as type', 'itemvat.itemvat_name as vat','itemvat.vat_value as vatValue', 'items.Item_id as id', 'itemquantity_instock.quantity as quantity')
                    ->where('items.is_product', '0')
                    ->where('items.deleted', '0')
                    ->whereNotIn('Item_id', $unWantedKeys)
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

    public function showAdd()
    {
        $data = [];
        $data['categories'] = $this->getCategories();
        $data['unities'] = $this->getUnities();
        $data['itemtypes'] = $this->getTypes();
        $data['itemvats'] = $this->getVat();

        return view('rawMaterials.add')->with($data);
    }

    public function postAdd(Request $request)
    {
        $data = $request->all();

        //validation
        $validator = Validator::make($data, [
            'code' => 'required|digits_between:1,20',
            'name' => 'required',
            'price' => 'required|digits_between:1,10',
            'quantity' => 'required|digits_between:1,20',
        ], $this->validationResponse());

        if($validator->fails())
        {
            $message = "";
            foreach ($validator->errors()->all() as $error)
            {
                $message = $message.$error."<br>";
            }
            $response['status'] = 500;
            $response['message'] = $message;
            return $response;
        }

        //check for unique code
        $result = Item::where('item_code', $data['code'])->where('deleted', 0)->count();
        if($result > 0)
            return getResponse(500, 507);

        $item = new Item();
        $item->item_code = $data['code'];
        $item->Item_name = $data['name'];
        $item->id_itemcategory = $data['category'];
        $item->id_itemunity = $data['unity'];
        $item->item_price = $data['price'];
        $item->id_vat = $data['vat'];
        $item->id_itemtype = $data['type'];
        $item->deleted = 0;
        $item->is_product = 0;

        try
        {
            DB::beginTransaction();
            $item->save();
            DB::table('itemquantity_instock')
                ->insert(['id_item'=>$item->Item_id, 'id_stockroom'=>1, 'id_furnisher'=>1, 'quantity'=>$data['quantity']]);
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return getResponse(500, 500);
        }

        return getResponse(200, 400);
    }

    public function edit(Request $request)
    {
        if($request->ajax())
        {
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
                        $validator = Validator::make($request->all(), ['value' => 'required|digits_between:1,20'], $this->validationResponse());
                        if($validator->fails())
                        {
                            $response['status'] = 500;
                            $response['message'] = $validator->errors()->all();
                            return $response;
                        }
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
                        $validator = Validator::make($request->all(), ['value' => 'required|digits_between:1,10'], $this->validationResponse());
                        if($validator->fails())
                        {
                            $response['status'] = 500;
                            $response['message'] = $validator->errors()->all();
                            return $response;
                        }
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
               return getResponse(500, 500);
            }

            return getResponse(200, 401);
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            $item = Item::find($request->pk);

            DB::beginTransaction();

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

                //check itemcompounds
                $itemcompounds = DB::table('itemcompound')
                    ->where('id_item_rawmaterial', $request->pk)
                    ->where('deleted', 0);
                $recordsItemcompounds = count($itemcompounds->get());
                if($recordsItemcompounds > 0)
                {
                    DB::rollBack();
                    return getResponse(500, 142);
                }

                /*$itemcompounds->update(['deleted' => 1]);
                //Itemcompounds Audit
                $audit['updated_table'] = 'itemcompound';
                foreach ($recordsItemcompounds as $item)
                {
                    $audit['id_record'] = $item->itemcompound_id;
                     MainController::audit($audit);
                }*/

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
                DB::rollBack();
                return getResponse(500, 500);
            }

            DB::commit();
            return getResponse(200, 402);
        }
    }

    public function addToItemCompound(Request $request)
    {
        if($request->ajax())
        {
            $duplicate = DB::table('itemcompound')
                ->where('id_item_rawmaterial', $request->pk)
                ->where('id_item_product', $request->product)
                ->where('deleted', 0)
                ->count();
            if($duplicate > 0)
            {
               return getResponse(500, 404);
            }
            else if($request->quantity == 0 || $request->quantity == "")
            {
                getResponse(500, 141);
            }

            DB::beginTransaction();
            try
            {
                DB::table('itemcompound')
                    ->insert(['id_item_product'=> $request->product, 'id_item_rawmaterial'=> $request->pk, 'quantity'=> $request->quantity]);
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                return getResponse(500, 500);
            }

            DB::commit();
            return getResponse(200, 403);
        }
    }

    public function editItemCompound(Request $request)
    {
        if($request->ajax())
        {
            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemcompound';

            try
            {
                switch($request->name)
                {
                    case "item-quantity":
                        DB::beginTransaction();

                        $item = DB::table('itemcompound')
                            ->where('itemcompound_id', $request->pk);
                        $old_value = $item->first()->quantity;
                        $validator = Validator::make($request->all(), ['value' => 'required|digits_between:1,20']);
                        if($validator->fails())
                        {
                            $response['status'] = 500;
                            $response['message'] = $validator->errors()->all();
                            return $response;
                        }
                        $itemcompound = $item->update(["quantity" => $request->value]);

                        $audit['updated_field'] = 'quantity';
                        $audit['id_record'] = $item->first()->itemcompound_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $item->first()->quantity;
                        $audit['updated_description'] = "Item update";
                        MainController::audit($audit);
                        break;
                }
            }
            catch (\Exception $e)
            {
                DB::rollback();
                return getResponse(500, 500);
            }

            DB::commit();
            return getResponse(200, 405);
        }
    }

}
