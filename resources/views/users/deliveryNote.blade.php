@extends('layouts.master')
@section('title', 'Bon de livraison')

@section('content')
    <h2>Bon de livraison n°{{ $order->id.date('-d-m-Y') }}</h2>
    <label>Date de la commande : {{ date('d F Y') }}</label>

    <h4>Objet : commande de matériel</h4>

    <p class="text-left">Bonjour M. {{ $order->name }} </p>
    
    <p class="text-justify">
        Le service commercial de Lutin Manager vous remercie pour votre commande.</br>
        Nous espérons avoir répondu à vos attentes.
    </p>
    <div class="table-responsive">
        <table class="table">
            <caption>Rappel de votre commande</caption>
            <td>
                <th class=".col-md-6">Articles</th>
                <th class=".col-md-3">Nombre</th>
                <th class=".col-md-3">Poids</th>
            </td>
        {{ $totalQuantity   = 0 }}
        {{ $totalWeight     = 0 }}
        @foreach($order->rows as $row)
            {{ $totalQuantity   = $totalQuantity + $row->quantity }}
            {{ $totalWeight     = $totalWeight + $row->item->weight }}
            <tr>
                <td class=".col-md-6"> {{ $row->item->name }} </td>
                <td class=".col-md-3"> {{ $row->quantity }} </td>
                <td class=".col-md-3"> {{ $row->item->weight }}g </td>
            </tr>
        @endforeach
        @if(sizeof($order->rows) > 1)
            <tr>
                <th class=".col-md-6"> TOTAL </th>
                <td class=".col-md-3"> {{ $totalQuantity }} </td>
                <td class=".col-md-3"> {{ $totalWeight + 300 }}g </td>
            </tr>
        @endif
        </table>
    </div>

    <p class="text-justify">
        
    </p>

    <p class="text-right">
        Cordialement,
        {{ $order->user->name }}
    </p>
@endsection