<?php

namespace App\Http\Controllers;

use App\Constants;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


use App\Models\Item;

class ItemController extends Controller
{
    public function __construct() { }

    public function viewAll()
    {
        $error = Session::get('error');
        $messages = Session::get('messages');

        $items=Item::where('active', 1);

        return view('items.viewAll',['items' => $items,'error' => $error,'messages'=>$messages]);
    }

    public function create(Request $request)
    {
        $messages=[];
        //rules to apply of each field
        $rulesItem = array(
            'name'             => 'string|required',
            'weight'            => 'integer|required|min:0',
        );

        $validatorItem = Validator::make($request->all(), $rulesItem);
        if ($validatorItem->fails()) {
            $messages = $validatorItem->messages()->getMessages();
            $error=Constants::MSG_ERROR_CODE;
        }
        else {

            $name = Request::input('name');
            $weight = Request::input('weight');

            $item = new Item();
            $item->name = $name;
            $item->weight = $weight;
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

    public function update(Request $request)
    {
        $messages=[];
        //rules to apply of each field
        $rulesItem = array(
            'id'                => 'integer|required',
            'name'             => 'string|required',
            'weight'            => 'integer|required|min:0',
        );

        $validatorItem = Validator::make($request->all(), $rulesItem);
        if ($validatorItem->fails()) {
            $messages = $validatorItem->messages()->getMessages();
            $error=Constants::MSG_ERROR_CODE;
        }
        else {
            $id = Request::input('id');
            $name = Request::input('name');
            $weight = Request::input('weight');

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
        return redirect()->route('items::viewAll')
            ->with('error',$error)
            ->with('messages',$messages);
    }

    public function delete($id)
    {
        $messages = [];
        $item=Item::find($id);
        if($item==null)
        {
            $messages[]=Lang::get('items.notFoundById',['id' => $id]);
            $error=Constants::MSG_ERROR_CODE;
        }
        else
        {
            $item->active=0;
            $item->save();
            $error=Constants::MSG_OK_CODE;
            $messages[]=Lang::get('items.deleted');
        }
        return redirect()->route('items::viewAll')
            ->with('error',$error)
            ->with('messages',$messages);
    }
}