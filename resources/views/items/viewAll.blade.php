@extends('layouts.master')
@section('title', 'Connexion')

@section('content')

    @extends('manager.menu')
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
                                <td>
                                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Modal_edit{{$item->id}}">
                                        edit
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Modal_delete{{$item->id}}">
                                        delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach($items as $item)
        <div class="modal fade" id="Modal_edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modifier article N°{{$item->id}}</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="#">
                            Libellé: <input type="text" name="itemName" value="{{$item->name}}" /> <br />
                            Poids: <input type="text" name="itemWeight" value="{{$item->weight}}" /> <br />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Enregistrer changement</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Modal_delete{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Supprimer Article N°{{$item->id}}</h4>
                    </div>
                    <div class="modal-body">
                        Etes-vous sûr ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                        <button type="button" class="btn btn-primary">Oui</button>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

@endsection