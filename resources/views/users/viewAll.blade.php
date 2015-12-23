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
                        <th>Rang</th>
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th class="text-right"></th>
                    </thead>
                    {{-- add form --}}
                    <form method="post" action="{{ URL::route('users::create') }}">
                        <tr>
                            <td><input name="name" type="text" class="form-control input-sm" required></input></td>
                            <td>
                                <select name="rank" class="form-control input-sm">
                                  <option value=0>Employé</option>
                                  <option value=1>Manager</option>>
                                </select>
                            </td>
                            <td><input type="email" name="email" class="form-control input-sm" required></td>
                            <td><input type="password" name="password" class="form-control input-sm" required></td>
                            <td class="text-right">
                                {{ csrf_field() }}
                                <button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ajouter" type="submit"><i class="fa fa-plus"></i></button>
                            </td>
                        </tr>
                    </form>
                    @foreach ($users as $user)
                        <tr>
                            <td><i class="fa {{ ($user->rank == 0) ? 'fa-industry' : 'fa-briefcase' }}  fa-lg"></i> &nbsp;{{ $user->name }}</td>
                            <td>{{ ($user->rank == 0) ? 'Employé' : 'Manager' }}</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td></td>
                            <td class="text-right">
                                <a href="{{ URL::route('users::edit', ['id' => $user->id ]) }}" data-toggle="tooltip" data-placement="top" title="Editer"><i class="fa fa-edit fa-2x"></i></a>
                                &nbsp;
                                <a href="#" onclick="deleteUser({{$user->id}})" data-toggle="tooltip" data-placement="top" title="Supprimer"><i class="text-danger fa fa-ban fa-2x"></i></a>
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
   var deleteUser = function(id) 
   {
       swal({
          title: LANG_USER_TITLE_DELETE,
          text: LANG_USER_CONFIRM_DELETE,
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
                url: '{{  URL::route('users::delete', ['id' => '']) }}/'+id, 
                success: onDelete
               });
          } 
          else
            swal(LANG_GLOBAL_CANCEL, LANG_USER_NOT_DELETE, "error");
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