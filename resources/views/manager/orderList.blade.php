@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')

    @extends('manager.menu')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-xs-12 text-center">
                <a href="#" class="btn btn-default">Importer les commandes</a>
            </div>
        <div class="row-fluid">
            <div class="col-xs-offset-1 col-xs-10">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>    </th>
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
                        <td class="status-progress text-center">&#8718;</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->user->name }}</td>
                        </tr>
                    @endforeach
                    <tr>

                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr>
                        <td class="status-progress text-center">&#8718;</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr>
                        <td class="status-progress text-center">&#8718;</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr>
                        <td class="status-progress text-center">&#8718;</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr>
                        <td class="status-waiting text-center">&#8718;</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr>
                        <td class="status-waiting text-center">&#8718;</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection