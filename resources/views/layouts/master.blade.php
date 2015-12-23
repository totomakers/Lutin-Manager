<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lutin Manager - @yield('title')</title>
    {{-- ================= --}}
    {{-- add your css here --}}
    {{-- ================= --}}
    {{--<link href="{{ URL::asset('bower/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <link href="{{ URL::asset('bower/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('bower/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('custom/css/superhero.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('bower/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('custom/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('bower/sweetalert/dist/sweetalert.css') }}" rel="stylesheet">
    @yield('css_page') {{-- additional css --}}
</head>
<body>
    @yield('content') {{-- content of your page --}}

{{-- ================= --}}
{{-- add your js here  --}}
{{-- ================= --}}
<script type="text/javascript" src="{{ URL::asset('bower/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('custom/js/app.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('bower/sweetalert/dist/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('bower/remarkable-bootstrap-notify/bootstrap-notify.min.js') }}"></script>

{{-- Affichage messages d'alerte --}}

@if(isset($error) && isset($messages))
    <script>

    @if($error==\Constants::MSG_OK_CODE)
        var titre ='Succes:';
        var type = 'success';
    @else
        var titre = '{{ ($error == \Constants::MSG_ERROR_CODE) ? 'Erreur' : 'Warning' }}';
        var type = '{{ ($error == \Constants::MSG_ERROR_CODE) ? 'danger' : 'warning' }}';
    @endif

    var message = '@foreach($messages as $message){{$message}}<br/>@endforeach';

        $.notify({
            // options
            title: titre+'<br/>',
            message: message
        },{
            // settings
            type: type
        });
    </script>
@endif

@yield('js_page') {{-- additional js --}}
</body>
</html>