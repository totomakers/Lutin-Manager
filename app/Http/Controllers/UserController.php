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
use App\Constants;

class UserController extends Controller
{
    public function __construct() {}

    public function viewAll()
    {
        $messages = \Session::get('messages');
        $error = \Session::get('error');

        $users = User::where('active', 1)->get();
        $list=[];
        foreach ($users as $user)
        {
            $total=Order::where('user_id','=',$user->id)->count();
            $today=Order::where('user_id','=',$user->id)->where('status','=',Constants::ORDER_VALIDATE)->count();
            $list[]=array($user,$total,$today);
        }
        //var_dump($list);


        return view('users.viewAll', ['list' => $list,'messages' => $messages, 'error' => $error]);
    }

    public function update($id, Request $request)
    {
        $error = Constants::MSG_OK_CODE;
        $messages = array();
        
        //rules to apply of each field
        $rulesUser = array(
            'id'                => 'integer|required',
            'name'              => 'string|required',
            'rank'              => 'integer|required|min:0',
            'email'             => 'string|required|regex:^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$',
            'password'          => 'string|required|regex:^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,15}$',
        );

        $validatorUser = Validator::make($request->all(), $rulesUser);
        if ($validatorUser->fails()) 
        {
            foreach($validatorUser->messages()->getMessages() as $key => $value)
                $messages[] = Lang::get('validator.global', ["name" => $key]);
                
            $error = Constants::MSG_ERROR_CODE;
        }
        else
        {
            $id = Request::input('id');
            $name = Request::input('name');
            $rank = Request::input('rank');
            $email = Request::input('email');
            $password = Request::input('password');

            $provider = new AccountProvider();
            $password = $provider->hashPassword($email, $password);

            $user = User::find($id);
            if(!$user)
            {
                $messages[] = Lang::get('users.notFound',["username" => $email]);
                $error = Constants::MSG_ERROR_CODE;
            }
            else
            {
                $user->name = $name;
                $user->rank = $rank;
                $user->email = $email;
                $user->sha1_password = $password;

                $user->save();
                $messages[] = Lang::get('user.updateOk');
            }
        }
        
        return redirect()->route('users::viewAll')->with(['messages' => $messages, 'error' => $error]);
    }
    
    public function delete($id)
    {
        $error = Constants::MSG_OK_CODE;
        $messages = array();
        
        $user = User::find($id);
        if(!$user)
        {
            $messages[] = Lang::get('users.notFound',["username" => $id]);
            $error=Constants::MSG_ERROR_CODE;
        }
        elseif ($user->active==0) 
        {
            $messages[] = Lang::get('users.notActive',["username" => $id]);
            $error = Constants::MSG_ERROR_CODE;
        }
        else
        {
            $user->active=0;
            $user->save();
            $messages[] = Lang::get('users.deleteOk',["username" => $user->email]);
        }
        
        return response()->json(["error" => $error, "messages" => $messages, "data" => $user]);
    }
    
    public function create(Request $request)
    {
        $error = Constants::MSG_OK_CODE;
        $messages = array();
        
        //rules to apply of each field
        $rulesUser = array(
            'id'                => 'integer|required',
            'name'              => 'string|required',
            'rank'              => 'integer|required|min:0',
            'email'             => 'string|required|regex:^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$',
            'password'          => 'string|required|regex:^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,15}$',
        );

        $validatorUser = Validator::make($request->all(), $rulesUser);
        if ($validatorUser->fails()) {
            foreach($validatorUser->messages()->getMessages() as $key => $value)
                $messages[] = Lang::get('validator.global', ["name" => $key]);
                
            $error=Constants::MSG_ERROR_CODE;
        }
        else
        {
            $id = Request::input('id');
            $name = Request::input('name');
            $rank = Request::input('rank');
            $email = Request::input('email');
            $password = Request::input('password');
                
            $user = User::find($id);
            if(!$user)
            {
                $messages[] = Lang::get('users.alreadyExist',["username" => $user->email]);
                $error = Constants::MSG_ERROR_CODE;
            }
            else
            {
                $provider = new AccountProvider();
                $password = $provider->hashPassword($email, $password);

                $user= new User();
                
                $user->name=$name;
                $user->rank=$rank;
                $user->email=$email;
                $user->sha1_password=$password;
                $user->active=1;

                $user->save();
                $messages[] = Lang::get('users.createOk',["username" => $email]);
            }
        }
        
        return redirect()->route('users::viewAll')->with(['messages' => $messages, 'error' => $error]);
    }
}