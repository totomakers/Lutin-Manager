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


class OrderController extends Controller
{
    public function __construct() { }

    public function viewAll()
    {
        return view('manager.orderList');
    }


    const DEFAULT_USER_ID = 0;
    public function importFile(Request $request)
    {
        //==============
        //Check
        //==============
        $inputName = 'csv_file';

        if (!$request->hasFile($inputName)) 
        {
            //ERROR
            return;
        }

        if (!$request->file($inputName)->isValid()) 
        {
            //ERROR
            return;
        }

        //==============
        //Treatment
        //==============

        $file = $request->file($inputName);
        if (($handle = fopen($file->path, "r")) !== false) 
        {
            $i = 0;
            setlocale(LC_ALL, 'fr_FR.UTF-8');

            while (($data = fgetcsv($handle, null, ";", "\"")) !== false) 
            {
                $i++;
                if ($i == 1)
                    continue; //skip the first line

                $date = $data[0];
                $orderNumber = (trim(substr($data[1], 7)));
                $customerName = $data[2];
                $adress = $data[3];

                //order already exist
                if(Order::find($orderNumber))
                {
                    //ERREUR
                    continue;
                }

                $order = new Order();
                $order->date = Carbon::parse($date);
                $order->id = intval($orderNumber);
                $order->name = $customerName;
                $order->address = $adress;
                $order->user_id = DEFAULT_USER_ID;
                $order->status = Order::WAITING;

                //======================
                //Treatment Order lines
                //======================
                $detail = str_getcsv($data[4], ";");
                $orderRows = [];
                foreach ($detail as $key => $value) 
                {
                    $item = trim(substr($value, 0, strpos($value, "(")));
                    if (strlen($item) <= 0)
                        continue;
                    $quantity = rtrim(substr($value, strpos($value, "(") + 1), ")");

                    $row = new OrderRow();
                    $ref = Item::where("name","=",$item)->first();
                    $row->item_id = $ref->id;
                    $row->order_id = $order->id;
                    $row->quantity = $quantity;

                    $orderRows[] = $row;
                }
            

                if(sizeof($orderRows) <= 0)
                {
                    //ERROR
                    continue;
                } 

                if($order->save())
                {
                    foreach($orderRows as $key => $value)
                        $value->save();
                }
                else
                {
                    //ERREUR
                }
            }

            fclose($handle);
        }
        else
        {
            //ERROR
        }
    }
}