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
use Auth;


class OrderController extends Controller
{
    public function __construct() { }

    public function viewAll()
    {
        //$connectedUser=Auth::user();

        $user=new User();
        $user->id=2;
        $user->name='Pere Joël';
        $user->rank=Constants::RANK_ADMIN;
        $connectedUser=$user;


        $error = \Session::get('error');
        $messages = \Session::get('messages');

        if ($connectedUser->rank==Constants::RANK_ADMIN)
        {
            $orders=Order::where('status','!=', Constants::ORDER_VALIDATE)->get();
            return view('manager.orderList',['orders' => $orders,'error'=>$error,'messages'=>$messages]);
        }
        else
        {
            $order=Order::where('status','=',Constants::ORDER_WAITING)->first();
            $order->user=$connectedUser;
            $order->save();
            return view('user.order',['order' => $order,'error'=>$error,'messages'=>$messages]);
        }
    }

    public function importFile(Request $request)
    {
        $messages=[];

        //==============
        //Check
        //==============
        $inputName = 'csv_file';


        if (!$request->hasFile($inputName))
        {
            $error=Constants::MSG_ERROR_CODE;
            $message[]=Lang::get('orders.noFile');
            return redirect()->route('orders::viewAll')
                ->with('error',$error)
                ->with('messages',$messages);
        }


        if (!$request->file($inputName)->isValid())
        {
            $error=Constants::MSG_ERROR_CODE;
            $message[]=Lang::get('orders.invalidFile');
            return redirect()->route('orders::viewAll')
                ->with('error',$error)
                ->with('messages',$messages);
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
                    $message[]=Lang::get('orders.alreadyExists',['id'=>$orderNumber]);
                    $error=Constants::MSG_WARNING_CODE;
                    continue;
                }

                $order = new Order();
                $order->date = Carbon::parse($date);
                $order->id = intval($orderNumber);
                $order->name = $customerName;
                $order->address = $adress;
                $order->user_id = Constants::DEFAULT_USER_ID;
                $order->status = Constants::ORDER_WAITING;

                //======================
                //Treatment Order lines
                //======================
                $detail = str_getcsv($data[4], ";");
                $orderRows = [];
                foreach ($detail as $key => $value)
                {
                    $item = trim(substr($value, 0, strpos($value, "(")));
                    if (strlen($item) <= 0)
                    {
                        $message[]=Lang::get('orders.hasNoProducts',['id'=>$orderNumber]);
                        $error=Constants::MSG_WARNING_CODE;
                        continue;
                    }
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
                    $error=Constants::MSG_WARNING_CODE;
                    $message[]=Lang::get('orders.noOrdersInFile');
                    continue;
                }

                if($order->save())
                {
                    foreach($orderRows as $key => $value)
                        $value->save();
                }
                else
                {
                    $error=Constants::MSG_ERROR_CODE;
                    $message[]=Lang::get('orders.saveError');
                }
            }

            fclose($handle);
        }
        else
        {
            $error=Constants::MSG_ERROR_CODE;
            $message[]=Lang::get('orders.fileError');
        }

        return redirect()->route('orders::viewAll')
            ->with('error',$error)
            ->with('messages',$messages);
    }


}