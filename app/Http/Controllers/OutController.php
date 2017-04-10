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

    public function addOut(Request $request)
    {
        if($request->ajax())
        {
            $outputsheet = new Outputsheet();
            $outputsheet->id_client = 0;
            $outputsheet->serial_number = $request->serial;
            $outputsheet->document_date = $request->date;
            $outputsheet->id_user = Auth::user()->User_id;
            $outputsheet->total_no_vat = $request->tnv;
            $outputsheet->total_vat = $request->tv;
            $outputsheet->total_with_vat = $request->twv;
            $outputsheet->total_for_interes = 0;
            $outputsheet->interes = 0;
            $outputsheet->amount_payed = $request->twv;
            $outputsheet->deleted = 0;
            $outputsheet->system_date = date("Y-m-d H:i:s");
            $outputsheet->comment = $request->comment;

            $items = $request->items;

            try
            {
                DB::beginTransaction();
                $outputsheet->save();

                foreach ($items as $item)
                {
                    //add records
                    $datasheet = new Datasheet();
                    $datasheet->source_sheet_id = $outputsheet->outsheet_id;
                    $datasheet->source_sheet_name = 'outputsheet';
                    $datasheet->id_item = $item['id'];
                    $datasheet->item_price = $item['price'];
                    $datasheet->quantity = $item['quantity'];
                    $datasheet->id_item = $item['id'];
                    $datasheet->subtotal_no_vat= $item['tnv'];
                    $datasheet->subtotal_vat = $item['tv'];
                    $datasheet->subtotal_with_vat = $item['twv'];
                    $datasheet->subtotal_for_interes = 0;
                    $datasheet->subdiscount = $item['discount'];
                    $datasheet->deleted = 0;
                    $datasheet->save();

                    //update materials
                    $sql = "select i.Item_id as id, itemcompound.quantity as icq, itemquantity_instock.quantity as isq
                          FROM items i
                          join itemcompound on itemcompound.id_item_rawmaterial = i.Item_id and itemcompound.deleted = 0
                          join itemquantity_instock on itemquantity_instock.id_item = i.Item_id and itemquantity_instock.deleted = 0
                          where itemcompound.id_item_product = :id";

                    $thisProductItems = DB::select($sql, [":id"=>$item['id']]);
                    foreach ($thisProductItems as $productItem)
                    {
                        if($productItem->isq < $item['quantity']*$productItem->icq)
                            return getResponse(500, 500);

                        $itemsStock = DB::table('itemquantity_instock')
                            ->where('id_item', $productItem->id)
                            ->where('deleted', 0);
                        $recordsItemsStock = $itemsStock->first();
                        $old_value = $recordsItemsStock->quantity;
                        $itemsStock->update(['quantity'=> (intval($old_value) - $item['quantity']*$productItem->icq)]);

                        //Audit
                        $audit = [];
                        $audit['updated_table'] = 'itemquantity_instock';
                        $audit['id_record'] = $recordsItemsStock->Itemquantity_instock_id;
                        $audit['updated_field'] = 'quantity';
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = intval($old_value) - $item['quantity']*$productItem->icq;
                        $audit['updated_description'] = "ItemStock update";
                        MainController::audit($audit);
                    }

                    //update product quantity
                    $itemsStock = DB::table('itemquantity_instock')
                        ->where('id_item', $item['id'])
                        ->where('deleted', 0);
                    $recordsItemsStock = $itemsStock->first();
                    $old_value = $recordsItemsStock->quantity;
                    $itemsStock->update(['quantity'=> (intval($item['quantity']) + intval($old_value))]);

                    //Audit
                    $audit = [];
                    $audit['updated_table'] = 'itemquantity_instock';
                    $audit['id_record'] = $recordsItemsStock->Itemquantity_instock_id;
                    $audit['updated_field'] = 'quantity';
                    $audit['old_value'] = $old_value;
                    $audit['new_value'] = intval($recordsItemsStock->quantity);
                    $audit['updated_description'] = "ItemStock update";
                    MainController::audit($audit);
                }

                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                //return $e;
                return getResponse(500, 500);
            }

            return getResponse(200, 406);
        }
    }

    public function showGRID()
    {
        return view('outputsheet.showGRID');
    }

    public function grid(Request $request)
    {
        if($request->ajax())
        {
            //show grid
            $records = Outputsheet::where('deleted', '0')->count();

            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'serial';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'comment';
                else if($request->order[0]['column'] == '2')
                    $orderBy = 'date';

                else $orderBy = '';

                $dir = $request->order[0]['dir'];
            }
            else
            {
                $orderBy = 'id';
                $dir = 'desc';
            }

            #server search
            if($request->search['value'] != '')
            {
                $items = DB::table('outputsheet')
                    ->select('serial_number as serial', 'comment', 'document_date as date', 'outsheet_id as id')
                    ->where('deleted', '0')
                    ->where(function($query) use ($request){
                        $query->where('serial_number', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('comment', 'like', '%'.$request->search['value'].'%');
                    })
                    ->offset($start)->limit($length+$start)
                    ->orderBy($orderBy, $dir)
                    ->get();
                $records = $items->count();
            }
            else
            {

                $items = DB::table('outputsheet')
                    ->select('serial_number as serial', 'comment', 'document_date as date', 'outsheet_id as id')
                    ->where('deleted', '0')
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

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            $datasheets = Datasheet::where('source_sheet_id', $id)
                ->where('deleted', 0)
                ->get();

            DB::beginTransaction();

            try
            {

                Outputsheet::where('outsheet_id', $id)
                    ->update(['deleted' => 1]);
                //Audit
                $audit = [];
                $audit['updated_table'] = 'outputsheet';
                $audit['id_record'] = $id;
                $audit['updated_field'] = 'deleted';
                $audit['old_value'] = 0;
                $audit['new_value'] = 1;
                $audit['updated_description'] = "Outputsheet Delete";
                MainController::audit($audit);

                Datasheet::where('source_sheet_id', $id)
                    ->update(['deleted' => 1]);

                foreach ($datasheets as $datasheet)
                {
                    #fetch items
                    $items = DB::table('itemquantity_instock')
                        ->where('id_item', $datasheet->id_item)
                        ->where('deleted', 0);

                    $items->update(['quantity'=> $items->first()->quantity - $datasheet->quantity]);

                    //Audit
                    $audit = [];
                    $audit['updated_table'] = 'itemquantity_instock';
                    $audit['id_record'] = $items->first()->Itemquantity_instock_id;
                    $audit['updated_field'] = 'quantity';
                    $audit['old_value'] = $items->first()->quantity + $datasheet->quantity;
                    $audit['new_value'] =$items->first()->quantity;
                    $audit['updated_description'] = "ItemStock update from outputsheet rollback";
                    MainController::audit($audit);

                    #fetch rawmaterials
                    $rawitems = DB::table('itemcompound')
                        ->where('id_item_product', $datasheet->id_item)
                        ->where('deleted', 0)
                        ->get();
                    foreach ($rawitems as $rawitem)
                    {
                        $q = DB::table('itemquantity_instock')
                            ->where('id_item', $rawitem->id_item_rawmaterial)
                            ->where('deleted', 0)
                            ->first()->quantity;
                        DB::table('itemquantity_instock')
                            ->where('id_item', $rawitem->id_item_rawmaterial)
                            ->where('deleted', 0)
                            ->update(['quantity'=> $q + $rawitem->quantity*$datasheet->quantity]);

                        //Audit
                        $audit = [];
                        $audit['updated_table'] = 'itemquantity_instock';
                        $audit['id_record'] = $items->first()->Itemquantity_instock_id;
                        $audit['updated_field'] = 'quantity';
                        $audit['old_value'] = $q;
                        $audit['new_value'] = $q + $rawitem->quantity*$datasheet->quantity;
                        $audit['updated_description'] = "ItemStock update from outputsheet rollback";
                        MainController::audit($audit);
                    }

                    $audit = [];
                    $audit['updated_table'] = 'datasheet';
                    $audit['id_record'] = $datasheet->datasheet_id;
                    $audit['updated_field'] = 'deleted';
                    $audit['old_value'] = 0;
                    $audit['new_value'] = 1;
                    $audit['updated_description'] = "Datasheet Delete";
                    MainController::audit($audit);
                }

                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                return getResponse(500, 500);
            }

            return getResponse(200, 508);

        }
    }


}
