<!DOCTYPE html>
<html>
<head>
  <title> @yield('title') | HealthLink</title>
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

  @if(Auth::check())
  @yield('controller')
  {!! Charts::styles() !!}
  <link rel="stylesheet" href="{{ asset('css/container.css') }}">
  @endif

</head>

<body ng-app="healthlink">

  @include('includes.navigation')
  @yield('content')

  @if(Auth::check())
  <!-- Modal Structure -->
  <div id="generateKey" class="modal" ng-controller="dashboard">
    <div class="modal-content">
      <h4>Generate A Key </h4>
      <p>The key that will be generated here will be used to unlock your data not permanently. This key is disposable. You can set when the key will be destroyed.</p>

      <br>
      <div class="input-field"> 
        <div class="form-group">
          <label class="control-label" for="">Assignee</label>
          <input type="text" ng-model="data.assignee" class="form-control" id="" placeholder="Assignee">
        </div>
      </div>
      <div class="input-field"> 
        <div class="form-group">
          <label class="control-label" for="">Recipient Email</label>
          <input type="email" ng-model="data.email" class="form-control" id="" placeholder="Recipient Email">
        </div>
      </div>
      
      <p>
        Set Key Expiration: The default would be 8 hours before the key expires.
        <input name="group1" type="radio" ng-model="data.duration" value="8" id="8" checked="" />
        <label for="8">8 Hours</label>
        &nbsp;
        <input name="group1" type="radio" ng-model="data.duration" value="48" id="1" />
        <label for="1">1 Day</label>
        &nbsp;
        <input name="group1" type="radio" ng-model="data.duration" value="72" id="3" />
        <label for="3">3 Days</label>
      </p>

      <button ng-click="myKey()" ng-disabled="!data.assignee || !data.email" class="btn">Generate Key</button>
      <div class="progress" ng-show="loading">
        <div class="indeterminate"></div>
      </div>
      <p>
        <input type="checkbox" id="show" ng-model="show" />
        <label for="show">Show Key</label>
      </p>
      <div class="input-field" ng-hide="show"> 
        <div class="form-group">
          <label class="control-label" for="">Private Key</label>
          <span class="help-block"></span>
          <input type="password" ng-model="data.key" placeholder="Private Key" class="form-control" disabled="">
        </div>
      </div>


      <div class="input-field" ng-show="show"> 
        <div class="form-group">
          <label class="control-label" for="">Private Key</label>
          <span class="help-block"></span>
          <input type="text" ng-model="data.key" placeholder="Private Key" class="form-control" disabled="">
        </div>
      </div>

      <button ng-click="submitKey(data)" class="btn right" ng-disabled="!data.assignee || !data.email || !data.key">Send and Save</button>
      <br>
    </div>
    <div class="modal-footer">
      <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">CLose</a>
    </div>
  </div>

  <!-- Modal Trigger -->
  
  <!-- Modal Structure -->
  <div id="upgradeCircle" class="modal bottom-sheet">
    <div class="modal-content">
      <h4>Upgrade My Cirlce</h4>
      <p>Please specify the number of people you want to add in your circle. Remember these are there slot in your list. No names yet are required.</p>

      <h1>Coming Soon</h1>
    </div>
  </div>
  @endif
  @include('includes.footer')

</body>
</html>
