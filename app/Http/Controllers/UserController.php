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

        return view('users.viewAll', ['users' => $users,'messages' => $messages, 'error' => $error]);
    }
    
    public function viewUpdate($id)
    {
        $user = User::find($id);

        $messages = \Session::get('messages');
        $error = \Session::get('error');

        //404
        if(!$user)  
            abort(404); 
        
        return view('users.edit', ['user' => $user,'messages' => $messages, 'error' => $error]);
    }

    public function update($id, Request $request)
    {
        $error = Constants::MSG_OK_CODE;
        $messages = array();
        
        //rules to apply of each field
        $rulesUser = array(
            'name'              => 'string|required',
            'rank'              => 'integer|required|min:0',
            'email'             => 'email|required',
            'password'          => 'string',
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

            if($password != '') 
                $password = AccountServiceProvider::hashPassword($email, $password);

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
                
                if($password != '') 
                    $user->sha1_password = $password;

                $user->save();
                $messages[] = Lang::get('user.updateOk');
            }
        }

        if($error == Constants::MSG_ERROR_CODE)
            return redirect()->back()->with(['messages' => $messages, 'error' => $error]);
        
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