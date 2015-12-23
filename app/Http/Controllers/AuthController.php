<?php

namespace App\Http\Controllers;

use App\Constants;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use App\Models\Order;

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
        $connectedUser = Auth::user();
        $order = Order::where('user_id','=',$connectedUser->id)->where('status','=',Constants::ORDER_IN_PROGRESS)->first();

        if($order)
        {
            $order->status=Constants::ORDER_WAITING;
            $order->user_id=Constants::DEFAULT_USER_ID;
            $order->save();
        }

        Auth::logout();

        return redirect()->route('auth::viewLogin');
    }
    
    //try to login with password and email
    public function login(Request $request)
    {
        //input file
        $email = $request->input('email');
        $password = $request->input('password');
        $rememberMe = $request->input('rememberMe');

        //try to login
        if(!Auth::attempt(['username' => $email, 'password' => $password], $rememberMe))
        {
            $error = Constants::MSG_ERROR_CODE;
            $message = Lang::get('auth.loginFail');
            return redirect()->back()->with(['error' => $error, 'messages' => [ $message ]]);
        }

        $error=Constants::MSG_OK_CODE;
        $message = Lang::get('auth.loginSuccess');
        return redirect()->route('orders::viewAll')->with(['error' => $error, 'messages' => [ $message ]]);
    }
}