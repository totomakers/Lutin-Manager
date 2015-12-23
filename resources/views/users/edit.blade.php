@extends('layouts.master')
@section('title', 'Edition de '.($user->name))

@section('content')
    @extends('manager.menu')
     <div class="container-fluid animated fadeIn">
        <div class="row-fluid">
            <div class="col-xs-offset-3 col-xs-6">
                <h2> <a href="{{ URL::route('users::viewAll') }}" ><i class="fa fa-backward"></i> Retour</a> - Formulaire d'édition de {{ $user->name }}</h2>
                <hr>
                <form class="form-horizontal" method="post" action="{{ URL::route('users::update', ['id' => $user->id ]) }}" >
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nom :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email :</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Mot de passe :</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rank" class="col-sm-2 control-label">Rang :</label>
                        <div class="col-sm-10">
                            <div class="radio radio-inline radio-primary">
                                <input type="radio" id="radio2" name="rank" value="0" @if($user->rank == 0) checked @endif>
                                <label for="radio1">Employé</label>
                            </div>
                            <div class="radio radio-inline radio-primary">
                                <input type="radio" id="radio2" name="rank" value="1"  @if($user->rank != 0) checked @endif>
                                <label for="radio2">Manager</label>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
     <div>
@endsection
