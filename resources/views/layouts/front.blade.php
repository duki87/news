<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Newsbit') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Expanded:400,600,700" rel="stylesheet">

    <!-- Stylesheets -->

    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="fonts/ionicons.css" rel="stylesheet">


    <link href="{{asset('css/styles.css')}}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

</head>
<body>

  @yield('header')
  @yield('content')
  @yield('footer')

  	<!-- SCIPTS -->

  	<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>

    <script src="{{asset('js/popper.min.js')}}"></script>

    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>

  	<script src="{{asset('js/tether.min.js')}}"></script>


  	<script src="{{asset('js/scripts.min.js')}}"></script>

  </body>
</html>
