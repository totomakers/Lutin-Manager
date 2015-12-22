<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


use App\Models\Item;


class ItemController extends Controller
{
    public function __construct() { }

    public function listAll()
    {
        $items=Item::where('active', 1);

        return view('items.viewAll',['items' => $items]);
    }

    public function add(Request $request)
    {
        //rules to apply of each field
        $rulesItem = array(
            'name'             => 'string|required',
            'weight'            => 'integer|required|min:0',
        );

        $validatorItem = Validator::make($request->all(), $rulesItem);
        if ($validatorItem->fails()) {
            $errors = $validatorItem->messages()->getMessages();
            return;
        }

        $name=Request::input('name');
        $weight=Request::input('weight');

        $item=new Item();
        $item->name=$name;
        $item->weight=$weight;
        if (!($item->save()))
        {
            //erreur
            return;
        }
        return redirect()->route('items::viewAll');
    }

    public function edit(Request $request)
    {
        //rules to apply of each field
        $rulesItem = array(
            'id'                => 'integer|required',
            'name'             => 'string|required',
            'weight'            => 'integer|required|min:0',
        );

        $validatorItem = Validator::make($request->all(), $rulesItem);
        if ($validatorItem->fails()) {
            $errors = $validatorItem->messages()->getMessages();
            return;
        }

        $id=Request::input('id');
        $name=Request::input('name');
        $weight=Request::input('weight');

        $item=Item::find($id);
        if($item==null)
        {
            //erreur
        }
        else
        {
            $item->name=$name;
            $item->weight=$weight;
            $item->save();
        }
        return redirect()->route('items::viewAll');
    }

    public function delete($id)
    {
        $item=Item::find($id);
        if($item==null)
        {
            //erreur
        }
        else
        {
            $item->active=0;
        }
        return redirect()->route('items::viewAll');
    }
}