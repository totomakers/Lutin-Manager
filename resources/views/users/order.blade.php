@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')

    @extends('users.header')
    <div class="container-fluid ">
        <div class="user-view">
            <div class="row-fluid ">
                <div class=" col-xs-2">
                    <div class="well well-lg text-center">
                        <p><b>Numéro de commande</b></p>

                        <p>{{ $order->id }}</p>

                        <p><b>Nom</b></p>

                        <p>{{ $order->name }}</p>

                        <p><b>Adresse</b></p>

                        <p>{{ $order->address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-10">

                <div class="table">
                    <div class="tab-head">
                        <div class="tab-tr col-xs-3">
                            Article
                        </div>
                        <div class="tab-tr col-xs-3">
                            Poid
                        </div>
                        <div class="tab-tr col-xs-3">
                            Quantité
                        </div>
                        <div class="tab-tr col-xs-3">
                            Saisie
                        </div>
                    </div>
                    <div class="tab-body">
                        @foreach($order->rows as $row)
                            <div class="tab-tr col-xs-3">
                                {{ $row->item->name }}
                            </div>
                            <div class="tab-tr col-xs-3">
                                {{ $row->item->weight }}
                            </div>
                            <div class="tab-tr col-xs-3">
                                x{{ $row->quantity }}
                            </div>
                            <div class="tab-tr col-xs-3">
                                <input type="number" class="input-group">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection