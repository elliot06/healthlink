@extends('layouts.noauth')
@section('title','Register Account')
@section('content')
<main>
	<div class="container">
		<div class="section"></div><br><br>
		<div>
			<div class="row">
				<div class="col s12 m6 offset-m3 l8 offset-l2 center">
					@if(!isset($error))
					<img src="{{ asset('img/success.png') }}" width="380">
					<h2>Verified!<br><small>{{ $user->name }}, you may now set up your account.</small></h2>
					<br><hr><br>
					<a href="{{ url('/account/setup') }}"><button type="button" class="btn waves-effect green pulse">set up my account</button></a>
					@else
					<img class="animated bounce infinite" src="{{ asset('img/cancel.png') }}" width="380">
					<h2>Ooops! Request can't be processed at this moment.</h2>
					<br><hr><br>
					<a href="{{ url('/') }}"><button type="button" class="btn waves-effect green pulse"><i class="material-icons left">home</i>Back to home</button></a>
					@endif
				</div>
			</div>
		</div>
	</div>
</main>
@endsection