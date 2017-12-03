@extends('layouts.master')
@section('title','Health Circle')
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/PatientController.js') }}"></script>
@endsection
@section('content')
<main ng-controller="circle">
	<div class="container-fluid">
		<div class="row">
			<div class="col s12 m12 l12">
				<h3>Health Circle <small>Circle of people where you can monitor their health records.</small></h3>

				@if(Session::has('success'))
				<div class="row">
					<div class="col s12 m12 l12">
						<div class="card-panel green">
							<span class="white-text">{{ Session::get('success') }}
							</span>
						</div>
					</div>
				</div>
				@endif
				
				<div class="row">
					<div class="col s12 m12 l12">
						<div class="card-panel white">
							<div class="row">
								<div class="col s12 m4 l4">
									<span class="black-text"><b>Total Cirlce Space:</b> {{ isset(Auth::user()->circle->total) ? Auth::user()->circle->total:'3 FREE' }} persons</span>
								</div>
								<div class="col s12 m4 l4">
									<span class="black-text"><b>Remaining Cirlce Space:</b> {{ $remaining }} persons</span>
								</div>
								<div class="col s12 m4 l4">
									<span class="black-text"><b>Total amount Paid:</b> {{ isset(Auth::user()->circle->total) ? 'Php':'' }} {{ isset(Auth::user()->circle->total) ? number_format(Auth::user()->circle->amount,2):'FREE' }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>


				@if(isset($friends) && $friends == 0 )
				<div class="card-panel cyan">
					<span class="white-text"><i class="material-icons left">info</i> You do not have any people yet in your circle. Would you like to add some? It can be your family relatives!
					</span>
				</div>

				<div class="col s12 m12 l6">
					@foreach($requests as $request)
					<div class="card-panel green">
						<span class="white-text"><i class="material-icons left">person</i>
							{{ $request->profile->last_name}}, {{ $request->profile->first_name}} wants to connect with you.
						</span>
						<div class="center">
							<br>
							<a href="{{ url('patient/accept/circle/'. $request->id) }}" type="button" class="waves-effect waves-light white black-text btn">Accept Request</a>
							<a href="{{ url('patient/deny/circle/'. $request->id) }}" type="button" style="background-color: red" class="waves-effect waves-light btn">Decline Request</a>
						</div>
					</div>
					@endforeach
				</div>

				@else
				
				@if(isset($requests))
				<div class="row">
					<div class="col s12 m12 l12">
						@foreach($requests as $request)
						<div class="card-panel cyan">
							<div class="white-text">
								<div class="row">
									<div class="col s12 m8 l8">
										<i class="material-icons left">person</i>{{ $request->profile->last_name}}, {{ $request->profile->first_name}} wants to connect with you.
									</div>
									<div class="col s12 m4 l4" >
										<a href="{{ url('patient/accept/circle/'. $request->id) }}" type="button" class="waves-effect waves-light white black-text btn">Accept Request</a>
										<a href="{{ url('patient/deny/circle/'. $request->id) }}" type="button" style="background-color: red" class="waves-effect waves-light btn">Decline Request</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				@endif
				<div class="card-panel white">
					<div class="row">
						@foreach($friends as $friend)
						<div class="col s12 m3 l3">
							<div class="card">
								<div class="card-image">
									<img src="{{ $friend->avatar }}">
									<span class="card-title truncate" style="background-color: #000; width: 100%; opacity: 0.6">{{ $friend->profile->last_name }}, {{ $friend->profile->first_name }}</span>
									<a href="{{ url('patient/get/circle/record/'.$friend->id) }}" class="btn-floating halfway-fab waves-effect waves-light green"><i class="material-icons">visibility</i></a>
								</div>
								<div class="card-content">
									<p><b>Date Joined: </b> {{ date('M j, Y g:i A', strtotime($friend->created_at)) }}</p>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>

				@endif


			</div>
		</div>

		<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
			<a class="modal-trigger" href="#addCircle"><button type="button" class="btn-floating btn-large red pulse">
				<i class="large material-icons">group_add</i>
			</button>
		</div>

		
		<!-- Modal Structure -->
		<div id="addCircle" class="modal">
			<div class="modal-content black-text">
				<h4 class="black-text">Add To Circle</h4>
				<p class="black-text">Let you send a request to people close to you to allow you see their health records. </p>
				<br>
				<form>
					<div class="input-field"> 
						<div class="form-group">
							<label class="control-label" for="">Username</label>
							<span class="help-block"></span>
							<input type="text" class="form-control" ng-keyup="searchUsername(username)" ng-model="username" placeholder="Username">
						</div>
					</div>
					
					<div class="progress" ng-show="loading">
						<div class="indeterminate"></div>
					</div>
					<!-- <button type="submit" class="btn">label</button> -->
				</form>

				<div class="row" ng-show="empty">
					<div class="col s12 m12 l12">
						<div class="card-panel red">
							<span class="white-text">No user or result found.
							</span>
						</div>
					</div>
				</div>
				<ul class="collection" ng-show="results">
					<li class="collection-item avatar" ng-repeat="result in results" ng-hide="result.id == {{ Auth::user()->id }}">
						<img src="<<result.avatar>>" alt="" class="circle">
						<span class="title black-text"><< result.patient_name.last_name >>, << result.patient_name.first_name >></span>
						<p class="black-text">@<< result.name >></p>
						<a ng-click="addCircle(result)" class="secondary-content"><i class="material-icons">add_circle</i></a>
					</li>
				</ul>


			</div>
			<div class="modal-footer">
				<a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Close</a>
			</div>
		</div>

	</div>

</main>

@endsection