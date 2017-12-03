@extends('layouts.master')
@section('title', $friend->name)
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/PatientController.js') }}"></script>
@endsection
@section('content')
<main ng-controller="records">
	<div class="container-fluid">
		<div class="row">
			<div class="col s12 m12">
				<div class="card-panel cyan darken-3">
					<span class="white-text"><i class="material-icons left">info</i> You are currenly viewing {{ $friend->name }}'s data.
					</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col col s12 m8 l8" >
				<h3>{{ $friend->profile->last_name }}, {{ $friend->profile->first_name }} {{ $friend->profile->middle_name }}, <small>{{ $friend->profile->age }} yrs old</small></h3>
			</div>
			<div class="col col s12 m4 l4" ><br>
				<p><b>Height: </b> {{ $friend->profile->height }} m &nbsp; <b>Weight: </b> {{ $friend->profile->weight }} kg</p>
				<p><b>Body Mass Index: </b> {{ substr($friend->profile->bmi, 0, 5) }} kg/m<sup>2</sup> | {{ $friend->profile->bmi_category }}</p>
			</div>
		</div>

		<div class="row">
			<div class="col col s12 m12 l12" >
				<div class="card large white" style="height: auto;">
					<div class="col s12 m12 l12" style="width: 100%">
							<ul class="tabs" style="overflow-x: hidden;">
								<li class="tab col s12 m6 l6"><a class="active" href="#test2">Personal Information</a></li>
								<li class="tab col s12 m6 l6"><a href="#test3">Health Records</a></li>
							</ul>
						</div>
					<div class="card-content black-text">
						
						<div id="test2" class="col s12">
							<div class="row">
								<div class="col s12 m6 l6">
									<div class="card large blue-grey darken-1">
										<div class="card-content white-text">
											<span class="card-title">Personal Data</span>
											<p><b>Contact: </b> {{ $friend->profile->cell_contact }} <b>Home: </b> {{ $friend->profile->home_contact }}</p>
											<p><b>Email Address: </b> {{ $friend->profile->email }}</p>
											<p><b>Gender: </b> {{ $friend->profile->gender }}</p>
											<p><b>Birthdate: </b> {{ $friend->profile->birthdate }}</p>
											<p><b>Birthplace: </b> {{ $friend->profile->birth_place }}</p>
											<p><b>Citizenship: </b> {{ $friend->profile->citizenship }}</p>
											<br>
											<div class="row">
												<div class="col s12 m6 l6">
													<p><b>Permanent Home Address: </b></p>
													<p><b>Address: </b> {{ $friend->address->perma_address }}</p>
													<p><b>City: </b> {{ $friend->address->perma_city }}</p>
													<p><b>Province: </b> {{ $friend->address->perma_province }}</p>
													<p><b>Region: </b> {{ $friend->address->perma_region }}</p>
													<p><b>Postal: </b> {{ $friend->address->perma_postal }}</p>
												</div>
												<div class="col s12 m6 l6">
													<p><b>Present Home Address: </b></p>
													<p><b>Address: </b> {{ $friend->address->pres_address }}</p>
													<p><b>City: </b> {{ $friend->address->pres_city }}</p>
													<p><b>Province: </b> {{ $friend->address->pres_province }}</p>
													<p><b>Region: </b> {{ $friend->address->pres_region }}</p>
													<p><b>Postal: </b> {{ $friend->address->pres_postal }}</p>
												</div>
											</div>

										</div>
									</div>
								</div>

								<div class="col s12 m6 l6">
									<div class="card large blue-grey darken-1">
										<div class="card-content white-text">
											<span class="card-title">Family Details</span>
											@foreach($friend->family as $family)
											<p><b>{{ strtoupper($family->relationship) }}: </b></p>
											<p><b>Name: </b> {{ $family->last_name }}, {{ $family->first_name }} {{ $family->middle_name }}</p>
											<p><b>Contact: </b> {{ $family->contact }}</p>
											<p><b>Email Address: </b> {{ $family->email }}</p>
											<p><b>Citizenship: </b> {{ $family->citizenship }}</p>
											<p><b>Occupation: </b> {{ $family->occupation }}</p>
											<br>
											@endforeach
										</div>
									</div>
								</div>
							</div>

						</div>
						<div id="test3" class="col s12">
							@if(count($friend->records) > 0)
							@foreach($friend->records as $record)
							<div class="col s12 m3 l3">
								<div class="card">
									<div class="card-image">
										<img style="height: 350px" src="{{ $record->img_url }}">
										<span class="card-title truncate" style="background-color: #000; width: 100%; opacity: 0.6"><a href="{{ url('patient/record/'. $record->id) }}">{{ $record->title }}</a></span>
									</div>
									<div class="card-content">
										<p class="truncate">{{ $record->content }}</p>
									</div>
								</div>
							</div>
							@endforeach
							@else
							<div class="row">
								<div class="col s12 m12">
									<div class="card-panel red">
										<span class="white-text">No available records yet with this account.
										</span>
									</div>
								</div>
							</div>
							@endif

						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Modal Structure -->
		<div id="dataView" class="modal">
			<div class="modal-content">
				<h4><< data.title >></h4>
				<p><b>Timestamp:</b> << data.created_at >></p>
				<p><b>Content:</b> << data.content >></p>
				<a href="<< img.img_url >>" data-lightbox="image-1" data-title="<< data.title >>" ng-repeat="img in data.imgs" style="margin: 10px;"><img src="<< img.img_url >>"  style="width: 220px; height: 250px; padding: 10px; border: 1px solid #000"></a>

			</div>
			<div class="modal-footer">
				<a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Close</a>
			</div>
		</div>
		
	</div>
	

	
	
</main>

@endsection