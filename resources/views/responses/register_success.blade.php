@extends('layouts.main')
@section('title','Register Account')
@section('content')
<main>
	<div class="container">
		<div class="section"></div><br><br>
		<div>
			<div class="row">
				<div class="col s12 m6 offset-m3 l6 offset-l3 center">
					<img class="animated rubberBand" src="{{ asset('img/success.png') }}" width="380">
					<h2>Alright {{ $data['name'] }}, we've sent you an email to verify your account.</h2>
					<br><hr><br>
					<a href="{{ url('/') }}"><button type="button" class="btn waves-effect green pulse"><i class="material-icons left">home</i>Back to home</button></a>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection