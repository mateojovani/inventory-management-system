<?php

namespace App\Http\Controllers;

use \Auth, \DB;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Entrysheet, App\Datasheet, App\Furnisher;

class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $furnisher = Furnisher::first();
        $date = date('d-m-Y');

        return view('entrysheet.show')->with(['furnisher'=>$furnisher, 'date'=>$date]);
    }

    public function addEntry(Request $request)
    {
        if($request->ajax())
        {
            $entrysheet = new Entrysheet();
            $entrysheet->id_furnisher = 0;
            $entrysheet->serial_number = $request->serial;
            //$entrysheet->document_date = $request->date;
            $entrysheet->document_date = date("Y-m-d H:i:s");
            $entrysheet->id_user = Auth::user()->User_id;
            $entrysheet->total_no_vat = $request->tnv;
            $entrysheet->total_vat = $request->tv;
            $entrysheet->total_with_vat = $request->twv;
            $entrysheet->total_for_interes = 0;
            $entrysheet->interes = 0;
            $entrysheet->amount_payed = $request->twv;
            $entrysheet->deleted = 0;
            $entrysheet->system_date = date("Y-m-d H:i:s");
            $entrysheet->comment = $request->comment;

            $items = $request->items;

            try
            {
                DB::beginTransaction();
                $entrysheet->save();

                foreach ($items as $item)
                {
                    //add records

                    $datasheet = new Datasheet();
                    $datasheet->source_sheet_id = $entrysheet->entrysheet_id;
                    $datasheet->source_sheet_name = 'entrysheet';
                    $datasheet->id_item = $item['id'];
                    $datasheet->item_price = $item['price'];
                    $datasheet->quantity = $item['quantity'];
                    $datasheet->id_item = $item['id'];
                    $datasheet->total_no_vat= $item['tnv'];
                    $datasheet->total_vat = $item['tv'];
                    $datasheet->total_with_vat = $item['twv'];
                    $datasheet->total_for_interes = 0;
                    $datasheet->discount = $item['discount'];
                    $datasheet->deleted = 0;
                    $datasheet->save();

                    //update material quantity
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
                    $audit['new_value'] = $recordsItemsStock->quantity + $old_value;
                    $audit['updated_description'] = "ItemStock update";
                    MainController::audit($audit);
                }

                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                return $e;
                //return getResponse(500, 500);
            }

            return getResponse(200, 406);
        }
    }
}
