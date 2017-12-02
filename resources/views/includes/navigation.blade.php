@if(Auth::check())
<ul id="dropdown1" class="dropdown-content">
  <!-- <li><a href="#!">Profile</a></li> -->
  <!-- <li><a href="http://korra.dev/account/settings">Settings</a></li> -->
  <li class="divider"></li>
  <li><a href="{{ url('/signout') }}">Log Out</a></li>
</ul>

<div class="navbar-fixed" ng-controller="navigation">
  <nav>
    <div class="nav-wrapper black">
      <a href="#!" class="brand-logo">HealthLink</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="{{ url('/patient/dashboard') }}"><i class="material-icons left">dashboard</i> Dashboard</a></li>
        <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i class="material-icons left">account_circle</i> {{ Auth::user()->name }}</a></li>
      </ul>
      <ul id="slide-out" class="side-nav fixed">
        <li><div class="user-view">
          <div class="background">
            <img src="http://mafaesamedia.com/wp-content/uploads/2016/06/xl-2016-online-medicine-1.jpg">
          </div>
          <a href="#!user"><img class="circle" src="{{ Auth::user()->avatar }}"></a>
          <a href="#!name"><span class="white-text name">{{ Auth::user()->name }}</span></a>
          <a href="#!email"><span class="white-text email">{{ Auth::user()->email }}</span></a>
        </div></li>
        <li><a class="modal-trigger" href="#generateKey"><i class="material-icons">vpn_key</i>Generate Key</a></li>
        <li><a href="{{ url('health/circle') }}"><i class="material-icons">group</i>Health Circle <span class="new red badge right" ng-show="notif"><< notif.length >></span></a></li>
        <li><a href="{{ url('patient/records') }}"><i class="material-icons">list</i>My Vault</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">Others</a></li>
        <li><a class="modal-trigger" href="#upgradeCircle"><i class="material-icons">add_circle</i>Upgrade Circle <span class="new red badge right" ng-show="notif"><< notif.length >></span></a></li>
        <li><a class="waves-effect" href="{{ url('/activity') }}"><i class="material-icons">assignment</i> Activity Log</a></li>
      </ul>
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
</div>

@else
<div class="navbar navbar-fixed ">
	<nav class="white wow fadeIn" data-wow-delay=".4s">
		<div class="nav-wrapper container">
			<a data-scroll href="{{ url('/') }}" id="HealthLink" class="brand-logo black-text">HealthLink</a>
			<ul class="right hide-on-med-and-down">
				<li><a class="black-text" data-scroll href="#howItWorks">How-it-Works</a></li>
				<li><a class="black-text" data-scroll href="#whyHealthLink">Why HealthLink?</a></li>
				<li><a href="{{ url('/signin') }}" class="waves-effect waves-light btn-large navbar-login">PATIENT</a></li>
				<li><a href="{{ url('/signin') }}" class="waves-effect waves-light btn-large navbar-login-doctor">DOCTOR</a></li>
			</ul>
		</div>
	</nav>
</div>
@endif
