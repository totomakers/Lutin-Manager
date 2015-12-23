@extends('layouts.master')
@section('title', 'Liste des Commandes')

@section('content')

    @extends('users.header')
    <div class="container-fluid ">
        <div class="animated fadeIn">
            <div class="row-fluid">   
                <div class="col-xs-offset-4 col-xs-4">
                    </br>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Numéro de commande :</strong> <span class="pull-right">{{ $order->id }}</span></li>
                        <li class="list-group-item"><strong>Nom :</strong> <span class="pull-right">{{ $order->name }}</span></li>
                        <li class="list-group-item"><strong>Adresse :</strong> <span class="pull-right">{{ $order->address }}</span></li>
                    </ul>
                    </br>
                </div>
            </div>
            <form action="{{ URL::route('orders::validate', [ "id"=>$order->id] ) }}" method="post" id="form_order_validate">
                <div class="row-fluid"> 
                    <div class="col-xs-offset-2 col-xs-8">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <th>Article</th>
                                    <th class="text-left">Poids</th>
                                    <th class="text-left">Quantité</th>
                                    <th>Saisie</th>
                                </thead>
                                <tbody>
                                    @foreach($order->rows as $row)
                                        <tr>
                                            <td>{{ $row->item->name }}</td>
                                            <td>{{ $row->item->weight }}</td>
                                            <td>x{{ $row->quantity }}</td>
                                            <td>
                                                <input type="number" min="0" max="{{ $row->quantity }}"
                                                       name="{{$row->item->name}}" class="form-control form_number input-sm" id="item-quantity-{{ $row->item->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>

                    <div class="col-xs-12 text-center">
                        <h4>+ Carton (300g)</h4>
                        {{--*/ $weight = 300; /*--}}
                        <div class="hidden">
                            @foreach($order->rows as $row)
                                {{$weight+=$row->item->weight*$row->quantity}}
                            @endforeach
                        </div>
                        <h2> Poid Total: {{$weight}}g</h2>
                    </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-center">
                    <button id="validate" class="btn btn-success btn-lg" onclick=validation()>Commande Terminée</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_page')
<script>

    $(function () 
    {
        $('#validate').prop('disabled', true);
    });

    var items_quantity = [ @foreach($order->rows as $row) { 'id' : '{{$row->item->id}}', 'quantity' : {{ $row->quantity }} },  @endforeach  ];

    var validation = function () 
    {
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
                if (isConfirm) 
                {
                    $('#form_order_validate').submit();
                }
                else 
                {
                    swal("Annulé", "", "error");
                }
            });
    }

    $(".form_number").change(function () 
    {
        for(var i = 0; i < items_quantity.length; i++)
        {
            var wanted = items_quantity[i].quantity;
            var currentVal = $("#item-quantity-"+items_quantity[i].id).val();

            if(wanted != currentVal)
            {
                $('#validate').prop('disabled', true);
                return;
            }
        }
        
        $('#validate').prop('disabled', false);
    });

</script>
@endsection