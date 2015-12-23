@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')

    @extends('manager.menu')
    <div class="container-fluid animated fadeIn">
        <div class="row-fluid">
            <div class="col-xs-12 text-center">
                <form method="post" action="{{ route('orders::import') }}" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <span class="btn btn-default btn-file">
                            Fichier de Commandes <input type="file" name="csv_file"/>
                        </span>
                        <input type="submit" class="btn btn-success" value="Importer"/>
                </form>
            </div>
            <div class="col-xs-12 text-center">
                Total: {{$total}}  |
                Validée: {{$totalValidated}} |
                <span class="status-waiting">En attente: {{$waiting}}</span>  |
                <span class="status-progress">Assignée: {{$assigned}}</span>  |
                <span class="status-success">Today: {{$today}} </span>
            </div>




            {{-- Liste des commandes --}}

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
                                        <i class="fa fa-square" data-toggle="tooltip" data-placement="left"
                                           title="En Attente"></i>
                                    </td>
                                @else
                                    <td class="status-progress text-center">
                                        <i class="fa fa-square" data-toggle="tooltip" data-placement="left"
                                           title="En Cours"></i>
                                    </td>
                                @endif
                                <td>{{ $order->id }}</td>
                                <td>{{ (new Carbon($order->date))->formatLocalized('%d %B %Y') }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->address }}</td>
                                <td>
                                    @if ($order->status==\App\Constants::ORDER_IN_PROGRESS)
                                        {{ $order->user->name }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Liste des employés avec stats--}}

            <div class="row-fluid">
                <div class="col-xs-offset-1 col-xs-10">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>Employé</th>
                            <th>Total commandes traitées (%)</th>
                            <th>Total commandes aujourd'hui (%)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($detailsUsers as $details)
                            <tr>
                                <td>{{ $details[0]->name }}</td>
                                <td>{{ $details[1] }} ({{ $details[2] }})</td>
                                <td>{{ $details[3] }} ({{ $details[4] }})</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

@endsection


