@extends('layouts.master')
@section('title', 'Bon de livraison')

@section('content')
    <div class="container-fluid animated fadeIn" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-xs-offset-2 col-xs-10">
                <img class="img-responsive pull-left" src="{{ URL::asset('custom/img/logo.png') }}" alt="Logo"
                     id="logo"/>

                <h1>Lutin Management</h1>

                <p class="subtitle">Et Joyeux Noël à  tous!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-2 col-xs-10">

                <h2>Bon de livraison n°{{ $order->id.date('-d-m-Y') }}</h2>
                <label>Date de la commande : {{ date('d F Y') }}</label>

                <h4>Objet : commande de matériel</h4>

                <p class="text-left">Bonjour M. {{ $order->name }} </p>

                <p class="text-justify">
                    Le service commercial de Lutin Manager vous remercie pour votre commande dont vous trouverez le
                    détail ci-dessous.</br>
                    Espérant avoir répondu à vos attentes,</br></br>
                    Cordialement,</br>
                    {{ $order->user->name }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-2 col-xs-5">
                <h3>Rappel de votre commande</h3>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class=".col-md-6">Articles</th>
                        <th class=".col-md-3">Nombre</th>
                        <th class=".col-md-3">Poids</th>
                    </tr>
                    </thead>
                    {{-- */
                    $totalQuantity   = 0;
                    $totalWeight     = 0
                    /* --}}
                    @foreach($order->rows as $row)
                        {{-- */
                        $totalQuantity   = $totalQuantity + $row->quantity;
                        $totalWeight     = $totalWeight + $row->item->weight
                        /* --}}
                        <tr>
                            <td class=".col-md-6"> {{ $row->item->name }} </td>
                            <td class=".col-md-3"> {{ $row->quantity }} </td>
                            <td class=".col-md-3"> {{ $row->item->weight }}g</td>
                        </tr>
                    @endforeach
                    @if(sizeof($order->rows) > 1)
                        <tr>
                            <th class=".col-md-6"> TOTAL</th>
                            <td class=".col-md-3"> {{ $totalQuantity }} </td>
                            <td class=".col-md-3"> {{ $totalWeight + 300 }}g</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-1 col-xs-10">

            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-1 col-xs-10">


                <div class="text-center">
                    @if(isset($error))
                        <a class="btn btn-success btn-lg hidden-print" href="{{URL::route('orders::viewAll')}}">Commande
                            suivante</a>
                    @endif
                    <a href="javascript:window.print()" class="btn btn-default btn-lg hidden-print">Imprimer le Bon de
                        Commande</a>
                </div>

            </div>
        </div>
    </div>
@endsection