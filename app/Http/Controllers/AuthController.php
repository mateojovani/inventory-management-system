<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator, Redirect, App\User, Auth;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view($this->lang.'/authenticate.login');
    }

    public function getRegister()
    {
        return view($this->lang.'/authenticate.register');
    }

    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:15',
            'User_email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        if ($validator->fails())
        {
            return Redirect::to('/register')->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->User_name = $request->username;
        $user->username = $request->username;
        $user->User_email = $request->User_email;
        $user->password = bcrypt($request->password);
        $user->id_role = 0;
        $user->save();

        if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password]))
            return Redirect::to('/');
        else return Redirect::to('/register');
    }

    public function postLogin(Request $request)
    {
        if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password]))
        {
            return Redirect::to('/');
        }
        else return Redirect::to('/login')->withErrors(['Can not Authenticate!']);
    }

    public function getLogout()
    {
        \Session::flush();
        return Redirect::to('/');
    }
}
