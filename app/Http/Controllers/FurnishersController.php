<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, App\Furnisher, \DB;

class FurnishersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('furnishers.show');
    }

    public function showGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = Furnisher::where('deleted', '0')->count();

            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'furnisher';
                else if($request->order[0]['column'] == '1')
                    $orderBy = 'address';
                else if($request->order[0]['column'] == '2')
                    $orderBy = 'email';
                else if($request->order[0]['column'] == '3')
                    $orderBy = 'phone';
                else if($request->order[0]['column'] == '4')
                    $orderBy = 'mobile';
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
                $furnishers = DB::table('furnishers')
                    ->select('furnisher_name as furnisher', 'furnisher_address as address', 'furnisher_email as email', 'furnisher_phone as phone', 'furnisher_mobile as mobile', 'furnisher_id as id')
                    ->where('deleted', '0')
                    ->where(function($query) use ($request){
                        $query->where('furnisher_name', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('furnisher_email', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('furnisher_address', 'like', '%'.$request->search['value'].'%');
                    })
                    ->offset($start)->limit($length+$start)
                    ->orderBy($orderBy, $dir)
                    ->get();
                $records = $furnishers->count();
            }
            else
            {
                $furnishers = DB::table('furnishers')
                    ->select('furnisher_name as furnisher', 'furnisher_address as address', 'furnisher_email as email', 'furnisher_phone as phone', 'furnisher_mobile as mobile', 'furnisher_id as id')
                    ->where('deleted', '0')
                    ->offset($start)->limit($length+$start)
                    ->orderBy($orderBy, $dir)
                    ->get();
                $records = $furnishers->count();
            }

            $json_data = array(
                "draw"            => $request->draw,
                "recordsTotal"    => $records,
                "recordsFiltered" => $records,
                "data"            => $furnishers
            );
            return $json_data;

        }
    }

    public function add(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            if($data['furnisher_name'] == '') return getResponse(500, 141);
            $furnisher = new Furnisher();
            $furnisher->furnisher_name = $data['furnisher_name'];
            $furnisher->furnisher_address = $data['furnisher_address'];
            $furnisher->furnisher_email = $data['furnisher_email'];
            $furnisher->furnisher_phone = $data['furnisher_phone'];
            $furnisher->furnisher_mobile = $data['furnisher_mobile'];

            try
            {
                DB::beginTransaction();
                $furnisher->save();
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                return getResponse(500, 500);
            }

            return getResponse(200, 302);
        }

    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            $furnisher = Furnisher::find($request->pk);
            DB::transaction(function () use ($furnisher, $request)
            {
                try
                {
                    $furnisher->update(["deleted" => 1]);

                    //Audit
                    $audit = [];
                    $audit['updated_table'] = 'furnishers';
                    $audit['updated_field'] = 'deleted';
                    $audit['id_record'] = $furnisher->Furnisher_id;
                    $audit['old_value'] = 0;
                    $audit['new_value'] = $furnisher->deleted;
                    $audit['updated_description'] = "Furnisher delete";
                    MainController::audit($audit);

                }
                catch(\Exception $e)
                {
                    return getResponse(500, 500);
                }

            });

            return getResponse(200, 303);
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax())
        {
            //Audit
            $audit = [];
            $audit['updated_table'] = 'furnishers';

            try
            {
                DB::beginTransaction();
                $furnisher = Furnisher::find($request->pk);

                switch($request->name)
                {
                    case "furnisher":
                        $old_value = $furnisher->furnisher_name;
                        $furnisher->update(["furnisher_name" => $request->value]);
                        $audit['updated_field'] = 'furnisher_name';
                        $audit['new_value'] = $furnisher->furnisher_name;
                        $audit['updated_description'] = "Furnisher update";
                        break;
                    case "address":
                        $furnisher = Furnisher::find($request->pk);
                        $old_value = $furnisher->furnisher_address;
                        $furnisher->update(["furnisher_address" => $request->value]);
                        $audit['updated_field'] = 'furnisher_address';
                        $audit['new_value'] = $furnisher->furnisher_address;
                        $audit['updated_description'] = "Furnisher update";
                        break;
                    case "email":
                        $furnisher = Furnisher::find($request->pk);
                        $old_value = $furnisher->furnisher_email;
                        $furnisher->update(["furnisher_email" => $request->value]);
                        $audit['updated_field'] = 'furnisher_email';
                        $audit['new_value'] = $furnisher->furnisher_email;
                        $audit['updated_description'] = "Furnisher update";
                        break;
                    case "phone":
                        $furnisher = Furnisher::find($request->pk);
                        $old_value = $furnisher->furnisher_phone;
                        $furnisher->update(["furnisher_phone" => $request->value]);
                        $audit['updated_field'] = 'furnisher_phone';
                        $audit['new_value'] = $furnisher->furnisher_phone;
                        $audit['updated_description'] = "Furnisher update";
                        break;
                    case "mobile":
                        $furnisher = Furnisher::find($request->pk);
                        $old_value = $furnisher->furnisher_mobile;
                        $furnisher->update(["furnisher_mobile" => $request->value]);
                        $audit['updated_field'] = 'furnisher_mobile';
                        $audit['new_value'] = $furnisher->furnisher_mobile;
                        $audit['updated_description'] = "Furnisher update";
                        break;
                }

                $audit['id_record'] = $furnisher->Furnisher_id;
                $audit['old_value'] = $old_value;
                MainController::audit($audit);
                DB::commit();
            }
            catch (\Exception $e)
            {
                DB::rollBack();
                return getResponse(500, 500);
            }

            return getResponse(200, 206);
        }
    }
}
