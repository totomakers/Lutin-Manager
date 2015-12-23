<?php

namespace App\Http\Controllers;

use App\Constants;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Auth;

use App\Models\Item;

class ItemController extends Controller
{
    public function __construct() { }

    public function viewAll()
    {
        $error = \Session::get('error');
        $messages = \Session::get('messages');

        $items=Item::where('active',Constants::ACTIVE)->get();

        return view('items.viewAll',['items' => $items,'error' => $error,'messages'=>$messages]);
    }

    public function create(Request $request)
    {
        $messages=[];
        //rules to apply on each field
        $rulesItem = array(
            'name'             => 'string|required',
            'weight'            => 'integer|required|min:0',
        );

        $validatorItem = Validator::make($request->all(), $rulesItem);
        if ($validatorItem->fails()) {
            $messages[] = Lang::get('items.invalidFOrm');
            $error=Constants::MSG_ERROR_CODE;
        }
        else {

            $name = $request->input('name');
            $weight = $request->input('weight');

            $item = new Item();
            $item->name = $name;
            $item->weight = $weight;
            $item->active = Constants::ACTIVE;
            if (!($item->save())) {
                $messages[] = Lang::get('items.notCreated');
                $error=Constants::MSG_ERROR_CODE;
            }
            else
            {
                $error=Constants::MSG_OK_CODE;
                $messages[] = Lang::get('items.created');
            }
        }
        return redirect()->route('items::viewAll')
            ->with('error',$error)
            ->with('messages',$messages);
    }

    public function viewUpdate($id)
    {
        $item = Item::find($id);

        $messages = \Session::get('messages');
        $error = \Session::get('error');

        //404
        if(!$item)
            abort(404);

        return view('items.edit', ['item' => $item,'messages' => $messages, 'error' => $error]);
    }

    public function update($id,Request $request)
    {
        $messages=[];
        //rules to apply of each field
        $rulesItem = array(
            'name'             => 'string|required',
            'weight'            => 'integer|required|min:0',
        );

        $validatorItem = Validator::make($request->all(), $rulesItem);
        if ($validatorItem->fails()) {
            foreach($validatorItem->messages()->getMessages() as $key => $value)
                $messages[] = Lang::get('validator.global', ["name" => $key]);

            $error = Constants::MSG_ERROR_CODE;
        }
        else {
            $name = $request->input('name');
            $weight = $request->input('weight');

            $item = Item::find($id);
            if ($item == null) {
                $messages[] = Lang::get('items.notFoundById',['id' => $id]);
                $error=Constants::MSG_ERROR_CODE;
            } else {
                $item->name = $name;
                $item->weight = $weight;
                $item->save();
                $error=Constants::MSG_OK_CODE;
                $messages[]=Lang::get('items.modified');
            }
        }

        if($error == Constants::MSG_ERROR_CODE)
            return redirect()->back()->with(['messages' => $messages, 'error' => $error]);

        return redirect()->route('items::viewAll')
            ->with('error',$error)
            ->with('messages',$messages);
    }

    public function delete($id)
    {
        $error=Constants::MSG_OK_CODE;
        $messages = [];

        $item=Item::find($id);
        if(!$item)
        {
            $messages[]=Lang::get('items.notFoundById',['id' => $id]);
            $error=Constants::MSG_ERROR_CODE;
        }
        elseif ($item->active==Constants::ARCHIVED)
        {
            $messages[] = Lang::get('items.notActive',['id' => $id]);
            $error = Constants::MSG_ERROR_CODE;
        }
        else
        {
            $item->active=Constants::ARCHIVED;
            $item->save();
            $messages[]=Lang::get('items.deleted');
        }

        return response()->json(["error" => $error, "messages" => $messages, "data" => $item]);
    }
}