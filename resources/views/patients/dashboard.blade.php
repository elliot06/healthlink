@extends('layouts.master')
@section('title','Dashboard')
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/PatientController.js') }}"></script>
@endsection
@section('content')
<main ng-controller="dashboard">
	<div class="container-fluid">
		<div class="row">
			<div class="col s12 m12 l12">
				<div class="card-panel white">
					<div class="row">
						<div class="col col s12 m8 l8" >
							<h3>{{ Auth::user()->profile->last_name }}, {{ Auth::user()->profile->first_name }} {{ Auth::user()->profile->middle_name }}, <small>{{ Auth::user()->profile->age }}</small></h3>
						</div>
						<div class="col col s12 m4 l4" ><br>
							<p><b>Height: </b> {{ Auth::user()->profile->height }} m &nbsp; <b>Weight: </b> {{ Auth::user()->profile->weight }} kg</p>
							<p><b>Body Mass Index: </b> {{ substr(Auth::user()->profile->bmi, 0, 5) }} kg/m<sup>2</sup> | {{ Auth::user()->profile->bmi_category }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col s12 m12 l12">
				<div class="card large white">
					<div class="row">

						<div class="col s12 m6 l5">
							{!! $tags->html() !!}
						</div>
						<div class="col s12 m6 l7 center">
							{!! $overview->html() !!}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col s12 m6 l6">
				<div class="card large grey darken-1">
					<div class="card-content white-text">
						<span class="card-title">Recent Records</span>
						@if(isset($records) && count($records) > 0)
						<ul class="collection">
							@foreach($records as $record)
							<li class="collection-item avatar black-text">
								<img src="{{ $record->img_url}}" alt="" class="circle">
								<span class="title truncate">{{ $record->title}}</span>
								<p class="truncate">{{ $record->content }}</p>
							</li>
							@endforeach
						</ul>
						@else
						<div class="row">
							<div class="col s12 m12 l12">
								<div class="card-panel cyan ">
									<span class="white-text"><i class="material-icons left">info</i> You have no records yet in your vault.
									</span>
								</div>
							</div>
						</div>
						@endif
					</div>
					<div class="card-action">
						<a class="white-text" href="{{ url('records') }}">cHECK VAULT</a>
					</div>
				</div>
			</div>

			<div class="col s12 m6 l6">
				<div class="card large white">
					<div class="card-content black-text">
						<span class="card-title">Your Circle</span>
						@if(isset($friends) && count($friends) > 0)
						<ul class="collection">
							@foreach($friends as $friend)
							<li class="collection-item avatar black-text">
								<img src="{{ $friend->avatar}}" alt="" class="circle">
								<span class="title">{{ $friend->profile->last_name}}, {{ $friend->profile->first_name}}</span>
								<p>@ {{ $friend->name }}
								</p>
							</li>
							@endforeach
						</ul>
						@else
						<div class="row">
							<div class="col s12 m12 l12">
								<div class="card-panel cyan ">
									<span class="white-text"><i class="material-icons left">info</i> You haven't added anyone yet in your circle. Send a requet now.
									</span>
								</div>
							</div>
						</div>
						@endif
					</div>
					<div class="card-action">
						<a class="black-text" href="{{ url('health/circle') }}">View Circle</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>

@section('scripts')
{!! $tags->script() !!}
{!! $overview->script() !!}
@endsection
@endsection