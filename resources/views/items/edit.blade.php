@extends('layouts.master')
@section('title', 'Edition de '.($item->name))

@section('content')
    @extends('manager.menu')
    <div class="container-fluid animated fadeIn">
        <div class="row-fluid">
            <div class="col-xs-offset-3 col-xs-6">
                <h2> <a href="{{ URL::route('items::viewAll') }}" ><i class="fa fa-backward"></i> Retour</a> - Formulaire d'édition de l'article: {{ $item->name }}</h2>
                <hr>
                <form class="form-horizontal" method="post" action="{{ URL::route('items::update', ['id' => $item->id ]) }}" >
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Libellé :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="libellé" value="{{ $item->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="weight" class="col-sm-2 control-label">Poids:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="weight" name="weight" value="{{ $item->weight }}">
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
