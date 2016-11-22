<?php

namespace App\Http\Controllers;

use App\Http\Requests, App\Audit, \DB, App\Item, Validator, App\User, \App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class MainController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function showHome()
    {
        return view($this->lang.'/home');
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view($this->lang.'/profile')->with('user', $user);
    }

    public function editProfile(Request $request)
    {
        if($request->ajax())
        {
            $response = [];
            $response['status'] = 200;
            $response['message'] = "Profile updated successfuly!";

            if($request->has('password'))
            {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:4|max:20',
                    'username' => 'required|min:4|max:20',
                    'email' => 'required|email|',
                    'phone' => 'digits_between:3,30',
                    'mobile' => 'digits_between:3,30',
                    'password' => 'min:5|max:20',
                    'confirm_password' => 'required|same:password'
                ]);
            }
            else
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:4|max:20',
                    'username' => 'required|min:4|max:20',
                    'email' => 'required|email|',
                    'phone' => 'digits_between:3,30',
                    'mobile' => 'digits_between:3,30'
                ]);
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

            //Audit
            $audit = [];
            $audit['updated_table'] = 'users';
            $audit['updated_field'] = 'deleted';
            $audit['updated_description'] = "User update";

            $user = User::find(Auth::user()->User_id);
            $user->User_name = $request->name;
            if($request->has('address'))
                $user->User_address = $request->address;
            $user->User_email = $request->email;
            if($request->has('phone'))
                $user->User_phone = $request->phone;
            if($request->has('mobile'))
                $user->User_mobile = $request->mobile;
            $user->username = $request->username;
            if($request->has('password'))
                $user->password = bcrypt($request->password);

            try
            {
                DB::beginTransaction();
                    $user->save();
                    //MainController::audit($audit);
                DB::commit();
            }
            catch (\Exception $e)
            {
                DB::rollback();
                $response['status'] = 500;
                $response['message'] = "Profile update failed!";
            }


            return $response;
        }

    }

    public static function audit($infoArr)
    {
        $audit = new Audit();
        $audit->updated_table = $infoArr['updated_table'];
        $audit->updated_field = $infoArr['updated_field'];
        $audit->id_record = $infoArr['id_record'];
        $audit->id_user = Auth::user()->User_id;
        $audit->updated_date = date('Y-m-d H:i:s');
        $audit->old_value = $infoArr['old_value'];
        $audit->new_value = $infoArr['new_value'];
        $audit->updated_description = $infoArr['updated_description'];
        $audit->save();
    }

    public static function checkRestrictions($id, $table)
    {
        //category restrictions | influence on items
        switch ($table)
        {
            case 'itemcategory':
                $items = Item::where('id_itemcategory', $id)
                    ->where('deleted', 0)
                    ->count();
                if($items > 0)
                    return true;
                break;
        }

        return false;
    }

}
