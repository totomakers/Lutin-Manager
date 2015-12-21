<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderRow;
use App\Models\User;
use Carbon\Carbon;


class OrderController extends Controller
{
    const DEFAULT_USER_ID = 0;

    public function __construct()
    {
    }

    /**
    * Import CSV File
    **/
    public function ImportOrders(Request $request)
    {
        //==============
        //Vérification =
        //==============
        $inputName = 'csv_file';

        if (!$request->hasFile($inputName)) 
        {
            //ERREUR
            return;
        }

        if (!$request->file($inputName)->isValid()) 
        {
            //ERREUR
            return;
        }

        //==============
        //Traitement ===
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
                    continue; // on ignore la premiere ligne

                $date = $data[0];
                $orderNumber = (trim(substr($data[1], 7)));
                $customerName = $data[2];
                $adress = $data[3];

                //La commande existe déjà
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

                //============
                //Traitement 
                //des lignes de commande
                //============
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
            

                //Vérification que notre commande a des lignes
                if(sizeof($orderRows) <= 0)
                {
                    //erreur
                    continue;
                } 

                //Vérification que la commande se sauvegarde bien
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
            //ERREUR
        }
    }
}