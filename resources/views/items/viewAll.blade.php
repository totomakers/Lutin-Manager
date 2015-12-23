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

                        {{-- add form --}}
                        <form method="post" action="{{ URL::route('items::create') }}">
                            <tr>
                                <td><input name="name" type="text" class="form-control input-sm" required /></td>

                                <td><input type="text" name="weight" class="form-control input-sm" required></td>
                                <td class="text-right">
                                    <button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ajouter" type="submit"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>{{ csrf_field() }}</td>
                            </tr>
                        </form>


                        <tbody>

                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->weight }}</td>
                                <td class="text-right">
                                    <a href="{{ URL::route('items::edit', ['id' => $item->id ]) }}" data-toggle="tooltip" data-placement="top" title="Editer"><i class="fa fa-edit fa-2x"></i></a>
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
        var deleteItem = function(id)
        {
            swal({
                        title: LANG_ITEM_TITLE_DELETE,
                        text: LANG_ITEM_CONFIRM_DELETE,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: COLOR_BUTTON_DANGER,
                        confirmButtonText: LANG_GLOBAL_DELETE,
                        cancelButtonText: LANG_GLOBAL_CANCEL,
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showLoaderOnConfirm: true,
                    },
                    function(isConfirm)
                    {
                        if (isConfirm)
                        {
                            $.ajax({
                                type: "DELETE",
                                url: '{{  URL::route('items::delete', ['id' => '']) }}/'+id,
                                success: onDelete
                            });
                        }
                        else
                            swal(LANG_GLOBAL_CANCEL, LANG_ITEM_NOT_DELETE, "error");
                    });
        }

        var onDelete = function(json)
        {
            var result = "success";
            if(json.error != API_SUCCESS_CODE) //Success code
                result = "danger";

            swal({
                        title: LANG_GLOBAL_RESULT,
                        text: json.messages[0],
                        type: result,
                        showCancelButton: false,
                        confirmButtonColor: COLOR_BUTTON_CONFIRM,
                        confirmButtonText: LANG_GLOBAL_RELOAD
                    },
                    function(isConfirm){
                        location.reload();
                    });
        }
    </script>
@endsection