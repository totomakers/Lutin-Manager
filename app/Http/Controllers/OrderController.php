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

    public function __construct()
    {
    }

    public function ImportOrders()
    {
        echo("toto");
        $file = 'c:\test.csv';
        $rows = array();

        if (($handle = fopen($file, "r")) !== false) {

            $i = 0;
            setlocale(LC_ALL, 'fr_FR.UTF-8');

            while (($data = fgetcsv($handle, null, ";", "\"")) !== false) {
                $i++;
                if ($i == 1)
                    continue; // on ignore la premiere ligne

                $date = $data[0];
                $orderNumber = (trim(substr($data[1], 7)));
                $customerName = $data[2];
                $adress = $data[3];

                $order = new Order();
                $order->date = Carbon::parse($date);
                $order->id = intval($orderNumber);
                $order->name = $customerName;
                $order->address = $adress;
                $order->user_id = 0;
                $order->status = 0;
                $order->save();

                $detail = str_getcsv($data[4], ";");
                foreach ($detail as $key => $value) {
                    $item = trim(substr($value, 0, strpos($value, "(")));
                    if (strlen($item)<=0)
                        continue;
                    $quantity = rtrim(substr($value, strpos($value, "(") + 1), ")");

                    $row = new OrderRow();
                    $ref = Item::where("name","=",$item)->first();
                    $row->item_id = $ref->id;
                    $row->order_id = $order->id;
                    $row->quantity = $quantity;
                    $row->save();

                    $items[$item] = $quantity;
                }
                $rows[] = array($date, $orderNumber, $customerName, $adress, $items);
            }

            fclose($handle);

        }


    }
}