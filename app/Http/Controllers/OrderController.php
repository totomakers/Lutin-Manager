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
        $connectedUser=Auth::user();

        $error = \Session::get('error');
        $messages = \Session::get('messages');

        if ($connectedUser->rank==Constants::RANK_ADMIN)
        {
            // recuperation de la liste des commandes et les totaux
            $orders=Order::where('status','!=', Constants::ORDER_VALIDATE)->get();
            $today = (new \DateTime())->setTime(0,0);
            // nombre de commandes total
            $totalOrders=Order::All()->count();
            // nombre de commandes validées
            $totalValidated=Order::where('status','=',Constants::ORDER_VALIDATE)->count();
            // nombre de commandes en attente
            $totalWaiting=Order::where('status','=',Constants::ORDER_WAITING)->count();
            // nombre de commandes en cours de traitement
            $totalAssigned=Order::where('status','=',Constants::ORDER_IN_PROGRESS)->count();
            // nombre de commandes validées aujourd'hui
            $todayOrders=Order::where('date_validation','>',$today)->count();


            // récuperation de la liste des utilisateurs avec leurs stats
            $users = User::where('active', Constants::ACTIVE)->where('rank',0)->get();
            $detailsUsers=[];
            foreach ($users as $user)
            {
                // nombre de commandes traités par l'utilisateur (au total)
                $total=Order::where('user_id','=',$user->id)->where('status','=',Constants::ORDER_VALIDATE)->count();
                $totalRatio=round(($total/$totalValidated)*100);
                // nombre de commandes traitées par l'utilisateur aujourd'hui
                $today=Order::where('user_id','=',$user->id)->where('status','=',Constants::ORDER_VALIDATE)->count();
                $todayRatio=round(($today/$todayOrders)*100);
                $detailsUsers[]=array($user,$total,$totalRatio,$today,$todayRatio);
            }

            return view('manager.orderList',
                ['orders' => $orders,
                'error'=>$error,
                'messages'=>$messages,
                'total'=>$totalOrders,
                'totalValidated'=>$totalValidated,
                'today'=>$todayOrders,
                'waiting'=>$totalWaiting,
                'assigned'=>$totalAssigned,
                'detailsUsers'=>$detailsUsers]);
        }
        else
        {
            // on recherche si on a déjà une commande attribuée
            $order=Order::where('user_id', $connectedUser->id)->Where('status',Constants::ORDER_IN_PROGRESS)->first();

            // sinon on prend la première libre et on l'assigne
            if ($order==null) {
                $order = Order::where('status', '=', Constants::ORDER_WAITING)->first();
                $order->user_id = $connectedUser->id;
                $order->status=Constants::ORDER_IN_PROGRESS;
                $order->save();
            }
            return view('users.order',['order' => $order,'error'=>$error,'messages'=>$messages]);
        }
    }

    public function viewOld()
    {
        $error = \Session::get('error');
        $messages = \Session::get('messages');

        $orders = Order::where('status','=',Constants::ORDER_VALIDATE)->get();

        return view('manager.orderValidated',['orders' => $orders,'error'=>$error,'messages'=>$messages]);
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
            $messages[]=Lang::get('orders.noFile');

            return redirect()->route('orders::viewAll')
                ->with('error',$error)
                ->with('messages',$messages);
        }


        if (!$request->file($inputName)->isValid())
        {
            $error=Constants::MSG_ERROR_CODE;
            $messages[]=Lang::get('orders.invalidFile');
            return redirect()->route('orders::viewAll')
                ->with('error',$error)
                ->with('messages',$messages);

        }

        //==============
        //Treatment
        //==============

        $file = $request->file($inputName);

        if (($handle = fopen($file, "r")) !== false)
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
                    $messages[]=Lang::get('orders.alreadyExists',['id'=>$orderNumber]);
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
                        $messages[]=Lang::get('orders.hasNoProducts',['id'=>$orderNumber]);
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
                    $messages[]=Lang::get('orders.noOrdersInFile');
                    continue;
                }

                if($order->save())
                {
                    foreach($orderRows as $key => $value)
                        $value->save();
                    $error=Constants::MSG_OK_CODE;
                    $messages[]=Lang::get('orders.importOk');
                }
                else
                {
                    $error=Constants::MSG_ERROR_CODE;
                    $messages[]=Lang::get('orders.saveError');
                }
            }

            fclose($handle);
        }
        else
        {
            $error=Constants::MSG_ERROR_CODE;
            $messages[]=Lang::get('orders.fileError');
        }

        return redirect()->route('orders::viewAll')
            ->with('error',$error)
            ->with('messages',$messages);
    }

    public function validateOrder(Request $request, $id)
    {
        $error = Constants::MSG_OK_CODE;
        $messages = [];

        $order = Order::find($id);

        foreach ($order->rows as $row)
        {
            if($request->input(str_replace(' ','_',$row->item->name)) != $row->quantity)
            {
                $messages[] = Lang::get('orders.quantityError', ["name" => $row->item->name]);
                $error = Constants::MSG_ERROR_CODE;
            }
        }
        if($error == Constants::MSG_ERROR_CODE)
            return redirect()->route('orders::viewAll')->with(['messages' => $messages, 'error' => $error]);
        if($order->status != Constants::ORDER_VALIDATE)
        {    
            $order->status = Constants::ORDER_VALIDATE;
            $order->date_validation = Carbon::now("GMT+1");
        }
        if(!$order->save())
        {
            $messages[] = Lang::get('orders.uniqueSaveError', ["id" => $order->id]);
            $error = Constants::MSG_ERROR_CODE;
            return redirect()->route('orders::viewAll')->with(['messages' => $messages, 'error' => $error]);
        }
        $messages[] = Lang::get('orders.saveOk');
        return view('users.deliveryNote', ['order' => $order, 'messages' => $messages, 'error' => $error]);
    }

    public function deliverynote($id)
    {
        $order = Order::find($id);
        return view('users.deliveryNote', ['order' => $order]);
    }
}