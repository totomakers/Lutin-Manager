@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')

    @extends('manager.menu')
    <div class="container-fluid">
        <div class="row-fluid">

            <div class="row-fluid">
                <div class="col-xs-offset-1 col-xs-10">

                    Details de la commande num {{ $order->id }}:<br />
                    Date: {{ (new Carbon($order->date))->formatLocalized('%d %B %Y') }} <br />
                    nom du client: {{ $order->name }} <br />
                    Adresse: {{ $order->address }} <br />
                    Assigné à : {{ $order->user->name }} <br />
                    <br />
                    Details:<br />
                    @foreach($order->rows as $row)
                        {{ $row->item->name }} x {{ $row->quantity }}<br />
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection