<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, App\Client, \DB;

class ClientsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function show()
    {
        return view($this->lang.'/clients.show');
    }

    public function showGrid(Request $request)
    {
        if($request->ajax())
        {
            $records = Client::where('deleted', '0')->count();

            $start = $request->start;
            $length = $request->length;

            #server order
            if($request->order[0]['column'] != '')
            {
                if($request->order[0]['column'] == '0')
                    $orderBy = 'client';
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
                $clients = DB::table('clients')
                    ->select('client_name as client', 'client_address as address', 'client_email as email', 'client_phone as phone', 'client_mobile as mobile', 'Client_id as id')
                    ->where('deleted', '0')
                    ->where(function($query) use ($request){
                        $query->where('client_name', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('client_email', 'like', '%'.$request->search['value'].'%');
                        $query->orWhere('client_address', 'like', '%'.$request->search['value'].'%');
                    })
                    ->offset($start)->limit($length+$start)
                    ->orderBy($orderBy, $dir)
                    ->get();
                $records = $clients->count();
            }
            else
            {
                $clients = DB::table('clients')
                    ->select('client_name as client', 'client_address as address', 'client_email as email', 'client_phone as phone', 'client_mobile as mobile', 'Client_id as id')
                    ->where('deleted', '0')
                    ->offset($start)->limit($length+$start)
                    ->orderBy($orderBy, $dir)
                    ->get();
                $records = $clients->count();
            }

            $json_data = array(
                "draw"            => $request->draw,
                "recordsTotal"    => $records,
                "recordsFiltered" => $records,
                "data"            => $clients
            );
            return $json_data;

        }
    }

    public function add(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;
            $response['message'] = "Client was created!";

            $data = $request->all();
            $client = new Client();
            $client->client_name = $data['client_name'];
            $client->client_address = $data['client_address'];
            $client->client_email = $data['client_email'];
            $client->client_phone = $data['client_phone'];
            $client->client_mobile = $data['client_mobile'];

            try
            {
                DB::beginTransaction();
                $client->save();
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                $response['status'] = 500;
                $response['message'] = "Client was not created!";
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
            $response['message'] = "Client successfully removed!";

            $client = Client::find($request->pk);
            DB::transaction(function () use ($client, $request)
            {
                try
                {
                    $client->update(["deleted" => 1]);

                    //Audit
                    $audit = [];
                    $audit['updated_table'] = 'clients';
                    $audit['updated_field'] = 'deleted';
                    $audit['id_record'] = $client->Client_id;
                    $audit['old_value'] = 0;
                    $audit['new_value'] = $client->deleted;
                    $audit['updated_description'] = "Client delete";
                    MainController::audit($audit);

                }
                catch(\Exception $e)
                {
                    $response['status'] = 500;
                    $response['message'] = "Client could not be deleted!";
                }

            });

            return $response;
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;
            $response['message'] = "Client edited successfully!";

            //Audit
            $audit = [];
            $audit['updated_table'] = 'clients';

            try
            {
                DB::beginTransaction();

                switch($request->name)
                {
                    case "client":
                        $client = Client::find($request->pk);
                        $old_value = $client->client_name;
                        $client->update(["client_name" => $request->value]);
                        $audit['updated_field'] = 'client_name';
                        $audit['id_record'] = $client->Client_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $client->client_name;
                        $audit['updated_description'] = "Client update";
                        break;
                    case "address":
                        $client = Client::find($request->pk);
                        $old_value = $client->client_address;
                        $client->update(["client_address" => $request->value]);
                        $audit['updated_field'] = 'client_address';
                        $audit['id_record'] = $client->Client_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $client->client_address;
                        $audit['updated_description'] = "Client update";
                        break;
                    case "email":
                        $client = Client::find($request->pk);
                        $old_value = $client->client_email;
                        $client->update(["client_email" => $request->value]);
                        $audit['updated_field'] = 'client_email';
                        $audit['id_record'] = $client->Client_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $client->client_email;
                        $audit['updated_description'] = "Client update";
                        break;
                    case "phone":
                        $client = Client::find($request->pk);
                        $old_value = $client->client_phone;
                        $client->update(["client_phone" => $request->value]);
                        $audit['updated_field'] = 'client_phone';
                        $audit['id_record'] = $client->Client_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $client->client_phone;
                        $audit['updated_description'] = "Client update";
                        break;
                    case "mobile":
                        $client = Client::find($request->pk);
                        $old_value = $client->client_mobile;
                        $client->update(["client_mobile" => $request->value]);
                        $audit['updated_field'] = 'client_mobile';
                        $audit['id_record'] = $client->Client_id;
                        $audit['old_value'] = $old_value;
                        $audit['new_value'] = $client->client_mobile;
                        $audit['updated_description'] = "Client update";
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
            }

            return $response;
        }
    }
}
