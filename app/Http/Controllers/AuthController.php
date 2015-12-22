<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderRow;
use App\Models\User;

use Auth;

class AuthController extends Controller
{
    public function __construct() {}
    
    public function viewLogin()
    {
        return view('auth.login');
    }
    
    public function logout()
    {
        Auth::logout();
    }
    
    //try to login with password and email
    public function login(Request $request)
    {
       //default value
       $error = false;
       $message = '';
       
       //input file
       $email = $request->input('email');
       $password = $request->input('password');
       $rememberMe = $request->input('rememberMe');

       //try to login
       if(!Auth::attempt(['username' => $email, 'password' => $password], $rememberMe))
            $message = Lang::get('auth.loginFail');
       else
            $message = Lang::get('auth.loginSuccess');
  
        return view('auth.doIt', ['error' => $error , 'messages' => [ $message ] ]); //redirect me to the right route motherfuck'a
    }
}