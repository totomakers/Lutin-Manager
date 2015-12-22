@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')

    @extends('manager.menu')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-xs-12 text-center">
                <a href="#" class="btn btn-success btn-import">Importer les commandes</a>
            </div>
            <div class="row-fluid">
                <div class="col-xs-offset-1 col-xs-10">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th></th>
                            <th>N° de Commande</th>
                            <th>Date Commande</th>
                            <th>Nom Client</th>
                            <th>Adresse</th>
                            <th>Employé</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)
                            <tr>
                                @if ($order->status==\App\Constants::ORDER_WAITING)
                                    <td class="status-waiting text-center">
                                        <i class="fa fa-square" data-toggle="tooltip" data-placement="left" title="Tooltip on left"></i>
                                    </td>
                                @else
                                    <td class="status-progress text-center"><i class="fa fa-square"></i></td>
                                @endif
                                <td>{{ $order->id }}</td>
                                <td>{{ (new Carbon($order->date))->formatLocalized('%d %B %Y') }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->address }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection