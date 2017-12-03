<!DOCTYPE html>
<html>
<head>
  <title>HealthLink</title>
  <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/hover.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/materialize-stepper.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" />

  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />

  <script type="text/javascript" src="{{ asset('js/angular.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/controllers/SignupController.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
  @yield('controller')

</head>

<body ng-app="healthlink">

  @yield('content')
  @include('includes.footer')
</body>
</html>
