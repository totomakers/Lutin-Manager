@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')
    @extends('manager.menu')
    <div class="container-fluid animated fadeIn">
        <div class="row-fluid">

            {{-- Liste des commandes --}}
            <div class="row-fluid">
                <div class="col-xs-offset-1 col-xs-10">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>N° de Commande</th>
                            <th>Date Commande</th>
                            <th>Nom Client</th>
                            <th>Adresse</th>
                            <th>Employé</th>
                            <th>Date validation</th>
                            <th>Bon de livraison</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ (new Carbon($order->date))->formatLocalized('%d %B %Y') }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ (new Carbon($order->date_validation))->formatLocalized('%d %B %Y') }}</td>
                                <td class="text-right">
                                    <a target='_blank' href="{{ URL::route('orders::delivery', ['id' => $order->id ]) }}" data-toggle="tooltip" data-placement="top" title="Bon de livraison"><i class="fa fa-edit fa-2x"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Liste des employés avec stats--}}

        </div>
    </div>

@endsection


