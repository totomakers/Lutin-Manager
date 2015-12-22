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
    <link href="{{ URL::asset('bower/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    @yield('css_page') {{-- additional css --}}
  </head>
  <body>
    @yield('content') {{-- content of your page --}}
    
    {{-- ================= --}}
    {{-- add your js here  --}}
    {{-- ================= --}}
    <script type="text/javascript" src="{{ URL::asset('bower/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    @yield('js_page') {{-- additional js --}}
  </body>
</html>