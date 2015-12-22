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
use App\Constans;


class UserController extends Controller
{
    public function __construct() { }

    public function viewAll()
    {
        $messages = Seesion::get('messages');
        $error = Seesion::get('error');

        $users=User::where('active', 1);

        return view('user.viewAll', ['users' => $users,'messages' => $messages, 'error' => $error]);
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
        if ($validatorUser->fails()) {
            foreach($validatorUser->messages()->getMessages() as $key => $value)
            {
                $messages[] = Lang::get('validator.global', ["name" => $key]);
            }
            $error=Constants::MSG_ERROR_CODE;
        }
        else
        {
            $id=Request::input('id');
            $name=Request::input('name');
            $rank=Request::input('rank');
            $email=Request::input('email');
            $password=Request::input('password');

            $provider = new AccountProvider();
            $password = $provider->hashPassword($email, $password);

            $user=User::find($id);
            if($user==null)
            {
                $messages[] = Lang::get('user.notFound',["username" => $email]);
                $error = Constants::MSG_ERROR_CODE;
            }
            else
            {
                $user->name=$name;
                $user->rank=$rank;
                $user->email=$email;
                $user->sha1_password=$password;

                $user->save();
                $messages[] = Lang::get('user.updateOk');
            }
        }
        return redirect()->route('user::viewAll')
            ->with('messages',$messages)
            ->with('error',$error);
    }
    
    public function delete($id)
    {
        $error = Constants::MSG_OK_CODE;
        $messages = array();
        
        $user=User::find($id);
        if($user==null)
        {
            $messages[] = Lang::get('user.notFound',["username" => $id]);
            $error=Constants::MSG_ERROR_CODE;
        }
        elseif ($user->active==0;) {
            $messages[] = Lang::get('user.notActive',["username" => $id]);
            $error=Constants::MSG_ERROR_CODE;
        }
        else
        {
            $user->active=0;

            $user->save();
            $messages[] = Lang::get('user.deleteOk',["username" => $email]);
        }
        
        return redirect()->route('user::viewAll')
            ->with('messages',$messages)
            ->with('error',$error);
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
            {
                $messages[] = Lang::get('validator.global', ["name" => $key]);
            }
            $error=Constants::MSG_ERROR_CODE;
        }
        else
        {
            $id=Request::input('id');
            $name=Request::input('name');
            $rank=Request::input('rank');
            $email=Request::input('email');
            $password=Request::input('password');
                
            $user=User::find($id);
            if($user!=null)
            {
                $messages[] = Lang::get('user.alreadyExist',["username" => $user->email]);
                $error=Constants::MSG_ERROR_CODE;
            }
            else{
                $provider = new AccountProvider();
                $password = $provider->hashPassword($email, $password);

                $user= new User();
                
                $user->name=$name;
                $user->rank=$rank;
                $user->email=$email;
                $user->sha1_password=$password;
                $user->active=1;

                $user->save();
                $messages[] = Lang::get('user.createOk',["username" => $email]);
            }
        }
        return redirect()->route('user::viewAll')
            ->with('messages',$messages)
            ->with('error',$error);
    }
}