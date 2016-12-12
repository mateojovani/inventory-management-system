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

    #Category

    public function showCatGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = DB::table('itemcategory')->where('deleted', '0')->count();
            $start = $request->start;
            $length = $request->length;

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
                ->offset($start)->limit($length+$start)
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
            //can delete?
            $stop = MainController::checkRestrictions($request->pk, 'itemcategory');
            if($stop) return getResponse(500, 142);

            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemcategory';
            $audit['updated_field'] = 'deleted';
            $audit['id_record'] =$request->pk;
            $audit['old_value'] = 0;
            $audit['new_value'] = 1;
            $audit['updated_description'] = "Category delete";

            DB::transaction(function () use ($request, $audit)
            {
                try
                {
                    DB::table('itemcategory')
                        ->where('Itemcategory_id', $request->pk)
                        ->update(['deleted' => 1]);
                    MainController::audit($audit);
                }
                catch(\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 106);
        }
    }

    public function addCategory(Request $request)
    {
        if($request->ajax())
        {
            if($request->name == '') return getResponse(500, 141);

            DB::transaction(function () use ($request)
            {
                try
                {
                    DB::table('itemcategory')
                        ->insert(['Itemcategory_name' => $request->name, 'is_for_product' => $request->type, 'id_itemcategory' => 0]);
                }
                catch (\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 105);
        }
    }

    public function editCategory(Request $request)
    {
        if($request->ajax())
        {
            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemcategory';
            $audit['id_record'] = $request->pk;
            $audit['updated_description'] = "Category update";

            try
            {
                DB::beginTransaction();

                switch($request->name)
                {
                    case "category":
                        $audit['updated_field'] = 'Itemcategory_name';
                        $audit['new_value'] = $request->value;
                        $item = DB::table('itemcategory')
                            ->where('Itemcategory_id', $request->pk);

                        $audit['old_value'] = $item->first()->Itemcategory_name;

                        $item->update(["Itemcategory_name" => $request->value]);
                        break;
                    case "name":
                        $audit['updated_field'] = 'is_for_product';
                        $item =  DB::table('itemcategory')
                            ->where('Itemcategory_id', $request->pk);
                        $audit['old_value'] = $item->first()->is_for_product;
                        $audit['new_value'] = $request->value;

                        $item->update(["is_for_product" => $request->value]);
                        break;
                }

                MainController::audit($audit);
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                return getResponse(500, 200);
            }

            return getResponse(200, 201);
        }
    }

    #Unity

    public function showUnityGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = DB::table('itemunity')->where('deleted', '0')->count();
            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'unity';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'item';

                $dir = $request->order[0]['dir'];
            }
            else
            {
                $orderBy = '';
                $dir = 'desc';
            }

            $items = DB::table('itemunity')
                ->select('itemunity.Itemunity_name as unity', 'itemunity.is_for_product as item', 'itemunity.Itemunity_id as id')
                ->where('itemunity.deleted', '0')
                ->orderBy($orderBy, $dir)
                ->offset($start)->limit($length+$start)
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

    public function deleteUnity(Request $request)
    {
        //can delete?
        $stop = MainController::checkRestrictions($request->pk, 'itemunity');
        if($stop) return getResponse(500, 142);

        //Audit
        $audit = [];
        $audit['updated_table'] = 'itemunity';
        $audit['updated_field'] = 'deleted';
        $audit['id_record'] =$request->pk;
        $audit['old_value'] = 0;
        $audit['new_value'] = 1;
        $audit['updated_description'] = "Unity delete";

        if($request->ajax())
        {

            DB::transaction(function () use ($request, $audit)
            {
                try
                {
                    DB::table('itemunity')
                        ->where('Itemunity_id', $request->pk)
                        ->update(['deleted' => 1]);
                    MainController::audit($audit);
                }
                catch(\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 110);
        }
    }

    public function addUnity(Request $request)
    {
        if($request->ajax())
        {

            if($request->name == '') return getResponse(500, 141);

            DB::transaction(function () use ($request)
            {
                try
                {
                    DB::table('itemunity')
                        ->insert(['Itemunity_name' => $request->name, 'is_for_product' => $request->type]);
                }
                catch(\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 111);
        }
    }

    public function editUnity(Request $request)
    {
        if($request->ajax())
        {
            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemunity';
            $audit['id_record'] =$request->pk;
            $audit['updated_description'] = "Unity update";

            try
            {
                DB::beginTransaction();

                switch($request->name)
                {
                    case "unity":
                        $audit['updated_field'] = 'Itemunity_name';
                        $audit['new_value'] = $request->value;
                        $item = DB::table('itemunity')
                            ->where('Itemunity_id', $request->pk);
                        $audit['old_value'] = $item->first()->Itemunity_name;

                        $item->update(["Itemunity_name" => $request->value]);
                        break;
                    case "name":
                        $audit['updated_field'] = 'is_for_product';
                        $audit['new_value'] = $request->value;
                        $item = DB::table('itemunity')
                            ->where('Itemunity_id', $request->pk);
                        $audit['old_value'] = $item->first()->is_for_product;

                        $item->update(["is_for_product" => $request->value]);
                        break;
                }
                MainController::audit($audit);
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                return getResponse(500, 500);
            }

            return getResponse(200, 202);
        }
    }

    #Type

    public function showTypeGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = DB::table('itemtype')->where('deleted', '0')->count();
            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'type';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'item';

                $dir = $request->order[0]['dir'];
            }
            else
            {
                $orderBy = '';
                $dir = 'desc';
            }

            $items = DB::table('itemtype')
                ->select('itemtype.itemtype_name as type', 'itemtype.is_for_product as item', 'itemtype.itemtype_id as id')
                ->where('itemtype.deleted', '0')
                ->offset($start)->limit($length+$start)
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

    public function deleteType(Request $request)
    {
        if($request->ajax())
        {
            //can delete?
            $stop = MainController::checkRestrictions($request->pk, 'itemtype');
            if($stop) return getResponse(500, 142);

            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemtype';
            $audit['updated_field'] = 'deleted';
            $audit['id_record'] =$request->pk;
            $audit['old_value'] = 0;
            $audit['new_value'] = 1;
            $audit['updated_description'] = "Type delete";

            DB::transaction(function () use ($request, $audit)
            {
                try
                {
                    DB::table('itemtype')
                        ->where('itemtype_id', $request->pk)
                        ->update(['deleted' => 1]);
                    MainController::audit($audit);
                }
                catch (\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 114);
        }
    }

    public function addType(Request $request)
    {
        if($request->ajax())
        {
            if($request->name == '') return getResponse(500, 141);
            DB::transaction(function () use ($request)
            {
                try
                {
                    DB::table('itemtype')
                        ->insert(['itemtype_name' => $request->name, 'is_for_product' => $request->type]);
                }
                catch (\Exception $e)
                {
                    return getResponse(500, 500);
                }
            });

            return getResponse(200, 113);
        }
    }

    public function editType(Request $request)
    {
        if($request->ajax())
        {

            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemtype';
            $audit['id_record'] =$request->pk;
            $audit['updated_description'] = "Type update";

            try
            {
                DB::beginTransaction();
                switch($request->name)
                {
                    case "type":
                        $audit['updated_field'] = 'itemtype_name';
                        $audit['new_value'] = $request->value;
                        $item = DB::table('itemtype')
                            ->where('itemtype_id', $request->pk);
                        $audit['old_value'] = $item->first()->itemtype_name;

                        $item->update(["itemtype_name" => $request->value]);
                        break;
                    case "name":
                        $audit['updated_field'] = 'is_for_product';
                        $audit['new_value'] = $request->value;
                        $item = DB::table('itemtype')
                            ->where('itemtype_id', $request->pk);
                        $audit['old_value'] = $item->first()->is_for_product;

                        $item->update(["is_for_product" => $request->value]);
                        break;
                }
                MainController::audit($audit);
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                return getResponse(500, 500);
            }

            return getResponse(200, 203);
        }
    }

    #VAT

    public function showVATGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = DB::table('itemvat')->where('deleted', '0')->count();
            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'vat';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'value';

                $dir = $request->order[0]['dir'];
            }
            else
            {
                $orderBy = '';
                $dir = 'desc';
            }

            $items = DB::table('itemvat')
                ->select('itemvat.itemvat_name as vat', 'itemvat.vat_value as value', 'itemvat.itemvat_id as id')
                ->where('itemvat.deleted', '0')
                ->offset($start)->limit($length+$start)
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

    public function deleteVAT(Request $request)
    {
        if($request->ajax())
        {
            //can delete?
            $stop = MainController::checkRestrictions($request->pk, 'itemvat');
            if($stop) return getResponse(500, 142);

            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemvat';
            $audit['updated_field'] = 'deleted';
            $audit['id_record'] =$request->pk;
            $audit['old_value'] = 0;
            $audit['new_value'] = 1;
            $audit['updated_description'] = "VAT delete";

            DB::transaction(function () use ($request, $audit)
            {
                try
                {
                    DB::table('itemvat')
                        ->where('itemvat_id', $request->pk)
                        ->update(['deleted' => 1]);
                    MainController::audit($audit);

                }
                catch(\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 118);
        }
    }

    public function addVAT(Request $request)
    {
        if($request->ajax())
        {
            if($request->name == '' || $request->type == '') return getResponse(500, 141);
            DB::transaction(function () use ($request)
            {
                try
                {
                    DB::table('itemvat')
                        ->insert(['itemvat_name' => $request->name, 'vat_value' => $request->type]);
                }
                catch(\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 117);
        }
    }

    public function editVAT(Request $request)
    {
        if($request->ajax())
        {

            //Audit
            $audit = [];
            $audit['updated_table'] = 'itemvat';
            $audit['id_record'] = $request->pk;
            $audit['updated_description'] = "VAT update";

            try
            {
                DB::beginTransaction();

                switch($request->name)
                {
                    case "vat-name":
                        $audit['updated_field'] = 'itemvat_name';
                        $audit['new_value'] = $request->value;
                        $item = DB::table('itemvat')
                            ->where('itemvat_id', $request->pk);
                        $audit['old_value'] = $item->first()->itemvat_name;

                        $item->update(["itemvat_name" => $request->value]);
                        break;
                    case "vat-value":
                        $audit['updated_field'] = 'itemtype_name';
                        $audit['new_value'] = $request->value;
                        $item = DB::table('itemvat')
                            ->where('itemvat_id', $request->pk);
                        $audit['old_value'] = $item->first()->vat_value;

                        $item->update(["vat_value" => $request->value]);
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

            return getResponse(200, 204);
        }
    }
}
