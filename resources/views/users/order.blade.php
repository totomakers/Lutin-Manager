@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')

    @extends('users.header')
    <div class="container-fluid ">
        <div class="user-view animated fadeIn">
            <form action="{{ URL::route('orders::validate', [ "id"=>$order->id] ) }}" method="post"
                  id="form_order_validate">
                {{csrf_field()}}
                <div class="row-fluid ">
                    <div class=" col-xs-2">
                        <div class="well well-lg text-center">
                            <p><b>Numéro de commande</b></p>

                            <p>{{ $order->id }}</p>

                            <p><b>Nom</b></p>

                            <p>{{ $order->name }}</p>

                            <p><b>Adresse</b></p>

                            <p>{{ $order->address }}</p>
                        </div>
                    </div>
                    <div class="col-xs-10">

                        <div class="table">
                            <div class="tab-head">
                                <div class="tab-tr col-xs-3">
                                    Article
                                </div>
                                <div class="tab-tr col-xs-3">
                                    Poid
                                </div>
                                <div class="tab-tr col-xs-3">
                                    Quantité
                                </div>
                                <div class="tab-tr col-xs-3">
                                    Saisie
                                </div>
                            </div>
                            <div class="tab-body">
                                @foreach($order->rows as $row)
                                    <div class="form-group">
                                        <div class="tab-tr col-xs-3">
                                            {{ $row->item->name }}
                                        </div>
                                        <div class="tab-tr col-xs-3">
                                            {{ $row->item->weight }}
                                        </div>
                                        <div class="tab-tr col-xs-3">
                                            x{{ $row->quantity }}
                                        </div>
                                        <div class="tab-tr col-xs-3">
                                            <input type="number" min="0" max="{{ $row->quantity }}"
                                                   name="{{$row->item->name}}" class="form-control form_number">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-2 text-center">
                        <div class="bar"></div>
                        <div class="weight">
                            <h4>+Carton (300g)</h4>
                            <?php $weight = 0; ?>
                            <div class="hidden">
                                @foreach($order->rows as $row)
                                    {{$weight+=$row->item->weight*$row->quantity}}
                                @endforeach
                                {{$weight += 300}}
                            </div>
                            <h2> Poid Total: {{$weight}}g
                            </h2>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-xs-offset-2 text-center">
                    <button id="validate" class="btn btn-success btn-lg" onclick=validation()>Commande Terminée</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_page')
    <script>
        $(document).ready(function () {
            $('#validate').prop('disabled', true);
        });
        var validation = function () {
            swal({
                        title: "Êtes-vous sur?",
                        text: "Vérifiez bien que la commande est pleine !",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Imprimer",
                        cancelButtonText: "Annuler",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#form_order_validate').submit();
                        }
                        else {
                            swal("Annulé", "", "error");
                        }
                    });
        }

        $(".form_number").change(function () {

            var row = $(".form-group");

            var value = $(".form_number").val();
            $('#validate').prop('disabled', false);
        });
    </script>
@endsection