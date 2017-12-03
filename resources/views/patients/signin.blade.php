@extends('layouts.noauth')
@section("title", "Sign In")
@section('content')
<main ng-controller="signin">
	<div id="particles-js"></div>
	<div class="signin-page">
		<div class="container animated zoomIn" style="padding-top: 4%">
			<div class="section"></div>
			<div class="row">
				@if(Session::has('error'))
				<div class="col s12 m8 offset-m2 l6 offset-l3">
					<div class="card-panel red">
						<span class="white-text">{{ Session::get('error') }}
						</span>
					</div>
				</div>
				@endif
				<div class="col s12 m8 offset-m2 l6 offset-l3">
					<div class="card large white darken-1" style="height: auto;" ng-hide="signin_card">
						<div class="card-content black-text center">
							<a href="{{ url('/') }}"><h1 class="title black-text">HealthLink</h1></a>
							<h4 class="center"><b>Patient account</b></h4>
							<h6>Enter your credentials</h6>
							<br><br>
							<div class="col s12 m8 offset-m2 l8 offset-l2">
								<div class="input-field"> 
									<div class="form-group">
										<label class="control-label" for="">Email Address</label>
										<span class="help-block"></span>
										<input type="email" class="form-control" ng-model="data.email" placeholder="Email Address">
									</div>
								</div>
								<div class="input-field"> 
									<div class="form-group">
										<label class="control-label" for="">Password</label>
										<span class="help-block"></span>
										<input type="password" class="form-control" ng-model="data.password" placeholder="Password">
									</div>
								</div>
							</div>
							<div class="col s12 m8 offset-m2 l8 offset-l2">
								<div class="preloader-wrapper big active" ng-show="loader">
									<div class="spinner-layer spinner-blue">
										<div class="circle-clipper left">
											<div class="circle"></div>
										</div>
										<div class="gap-patch">
											<div class="circle"></div>
										</div>
										<div class="circle-clipper right">
											<div class="circle"></div>
										</div>
									</div>

									<div class="spinner-layer spinner-red">
										<div class="circle-clipper left">
											<div class="circle"></div>
										</div>
										<div class="gap-patch">
											<div class="circle"></div>
										</div>
										<div class="circle-clipper right">
											<div class="circle"></div>
										</div>
									</div>

									<div class="spinner-layer spinner-yellow">
										<div class="circle-clipper left">
											<div class="circle"></div>
										</div>
										<div class="gap-patch">
											<div class="circle"></div>
										</div>
										<div class="circle-clipper right">
											<div class="circle"></div>
										</div>
									</div>

									<div class="spinner-layer spinner-green">
										<div class="circle-clipper left">
											<div class="circle"></div>
										</div>
										<div class="gap-patch">
											<div class="circle"></div>
										</div>
										<div class="circle-clipper right">
											<div class="circle"></div>
										</div>
									</div>
								</div>
								<br>
								<br>
								<input type="hidden" name="_token" ng-model="data._token" value="{{ csrf_token() }}">
								<button type="submit" ng-click="findAccount(data)" ng-disabled="!data.email || !data.password" class="btn btn-large">Continue <i class="material-icons right">arrow_forward</i></button>

								<div class="section"></div>
								<p class="center">Can't login with you account? <a href="#modal1" class=" modal-trigger">Retrive it here.</a></p>

							</div>
						</div>
					</div>

					<div class="card large white darken-1" style="height: auto;" ng-show="verification">
						<div class="card-content black-text center">
							<a href="{{ url('/') }}"><h1 class="title black-text">Verification Code</h1></a>
							<h5 class="center"><b>We've sent you a verification code to<br> confirm your login attempt.</b></h5>
							<h6>Enter the code that was sent to your email.</h6>
							<br><br>
							<form action="{{ url('/verify/code') }}" method="POST">
								<div class="col s12 m8 offset-m2 l8 offset-l2">
									<div class="input-field"> 
										<div class="form-group">
											<label class="control-label" for="">Code</label>
											<span class="help-block"></span>
											<input type="text" class="form-control" ng-model="data.code" name="code" placeholder="XXXXXXXXXX">
										</div>
									</div>
								</div>
								<div class="col s12 m8 offset-m2 l8 offset-l2">
									<br>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<button type="submit" ng-disabled="!data.code" class="btn btn-large">Continue <i class="material-icons right">arrow_forward</i></button>

									<div class="section"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<p class="center">Don't have an account yet? <a href="{{ url('/') }}">Create here.</a></p>
			</div>
			<div class="section"></div>
		</div>
	</div>


	<div id="modal1" class="modal bottom-sheet">
		<div class="modal-content center">
			<h4>Got lost? We'll find Your Account!</h4>
			<p>We’ll send you an email to confirm your email address.</p>
		</div>
		<div class="row">
			<div class="col s12 m4 offset-m4 l4 offset-l4">
				<div class="input-field"> 
					<div class="form-group">
						<label class="control-label" for="">Email Address</label>
						<span class="help-block"></span>
						<input type="email" class="form-control" ng-model="data.email" placeholder="name@example.com">
					</div>
				</div>
				<center>
					<div class="preloader-wrapper big active" ng-show="loader2">
						<div class="spinner-layer spinner-blue">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>

						<div class="spinner-layer spinner-red">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>

						<div class="spinner-layer spinner-yellow">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>

						<div class="spinner-layer spinner-green">
							<div class="circle-clipper left">
								<div class="circle"></div>
							</div>
							<div class="gap-patch">
								<div class="circle"></div>
							</div>
							<div class="circle-clipper right">
								<div class="circle"></div>
							</div>
						</div>
					</div>
				</center>
				<br>
				<center><button ng-disabled="!data.email" ng-click="confirmEmail(data)" class="btn">confirm</button></center>
			</div>
		</div>
	</div>
</main>	
@endsection