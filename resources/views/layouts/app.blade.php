<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--<title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>Gerenciador de Solicitação</title>

    <!-- Scripts -->
    <!-- <script src="{{-- asset('js/app.js') --}}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <!-- <link href="{{-- asset('css/app.css') --}}" rel="stylesheet"> -->
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- nosso css -->
    <link href="{{ asset('css/tcc.css') }}" rel="stylesheet">
    
</head>
<body>
     
    <header class="titulo-tcc">
        <h1 > Gerenciador de Solicitação</h1>
    </header>
    <main class="py-4">
        @yield('content')
    </main>
</body>
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<!-- <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}" defer></script> -->
@stack('scripts')
</html>
