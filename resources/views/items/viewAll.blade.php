@extends('layouts.master')
@section('title', 'Connexion')

@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="col-xs-offset-1 col-xs-10">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>Libellé</th>
                            <th>Poids</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->weight }}</td>
                                <td> Edit | Delete</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection