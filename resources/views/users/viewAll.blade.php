@extends('layouts.master')
@section('title', 'Liste des Employées')

@section('content')
    @extends('manager.menu')
    <div class="container-fluid animated fadeIn">
        <div class="row-fluid">
            <div class="col-xs-offset-2 col-xs-8">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <th>Nom</th>
                        <th>Rank</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Aujourd'hui</th>
                        <th class="text-right">Editer</th>
                        <th class="text-right">Supprimer</th>
                    </thead>
                    @foreach ($list as $details)
                        <tr>
                            <td>{{ $details[0]->name }}</td>
                            <td>{{ ($details[0]->rank == 0) ? 'Employé' : 'Manager' }}</td>
                            <td>{{ $details[0]->email }}</td>
                            <td>{{ ($details[0]->rank == 0) ? $details[1] : 'NA' }}</td>
                            <td>{{ ($details[0]->rank == 0) ? $details[2] : 'NA' }}</td>
                            <td class="text-right">
                                <a href="#" data-toggle="tooltip" data-placement="top" title="Editer"><i class="fa fa-edit fa-2x"></i></a>
                            </td>
                            <td class="text-right">
                                <a href="#" onclick="deleteUser({{$details[0]->id}})" data-toggle="tooltip" data-placement="top" title="Supprimer"><i class="text-danger fa fa-trash fa-2x"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js_page')
<script>
   var deleteUser = function(id) {
       swal({
          title: "Voulez-vous supprimer ce lutin ?",
          text: "Ce lutin ne pourras pas être récuperé êtes-vous sûr ?",
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
            swal("Supprimé !", "Votre Lutin a été supprimé", "success");
          } 
          else {
             swal("Anulé", "Votre Lutin n'a pas été supprimé", "error");
          }
        });
   }
</script>
@endsection