@extends('layouts.master')
@section('title', 'Connexion')

@section('content')

    @extends('manager.menu')
    <div class="container-fluid animated fadeIn">
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="col-xs-offset-1 col-xs-10">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>Libellé</th>
                            <th>Poids</th>
                            <th class="text-right">Editer</th>
                            <th class="text-right">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->weight }}</td>
                                <td class="text-right">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Editer"><i class="fa fa-edit fa-2x"></i></a>
                                </td>
                                <td class="text-right">
                                    <a href="#" onclick="deleteItem({{$item->id}})" data-toggle="tooltip" data-placement="top" title="Supprimer"><i class="text-danger fa fa-trash fa-2x"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_page')
    <script>
        var deleteItem = function(id) {
            swal({
                        title: "Voulez-vous supprimer cet article ?",
                        text: "Cet article ne pourras pas être récuperé êtes-vous sûr ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Supprimer",
                        cancelButtonText: "Annuler",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm)
                    {
                        if (isConfirm) {
                            swal("Supprimé !", "Cet article a été supprimé", "success");
                        }
                        else {
                            swal("Anulé", "L'article n'a pas été supprimé", "error");
                        }
                    });
        }
    </script>
@endsection