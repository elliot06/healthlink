@extends('layouts.master')
@section('title','Logs')
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/PatientController.js') }}"></script>
@endsection
@section('content')
<main ng-controller="dashboard">
	<div class="container-fluid">
		<div class="row">
			<div class="col col s12 m12 l12" >
				<h3>Your Activity Logs <small>You can see your activity here.</small></h3>
			</div>
		</div>

		@if(isset($activities) && count($activities) == 0)
		<div class="row">
			<div class="col s12 l12">
				<div class="card-panel cyan">
					<span class="white-text"><i class="material-icons left">info</i> You don't have any activities yet.
					</span>
				</div>
			</div>
		</div>
		@else
		<div class="row">
			<div class="col s12 l12">
				<ul class="collection">
					@foreach($activities as $activity)
					<li class="collection-item"><i class="material-icons left">info</i> {{ $activity->content }} <span class="right">{{ date('M j, Y g:i A, l', strtotime($activity->created_at)) }} | <small>{{ $activity->created_at->diffForHumans() }}</small></span></li>
					@endforeach
				</ul>
			</div>
		</div>
		@endif
		
	</div>
	
</main>

@endsection