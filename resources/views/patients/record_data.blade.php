@extends('layouts.master')
@section('title', isset($record) ? $record->title:'Forbidden')
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/PatientController.js') }}"></script>
@endsection
@section('content')
<main ng-controller="records">
	<div class="{{ Auth::check() ? 'container-fluid':'container'}}">
		@if(isset($error))
		<div class="row">
			<div class="col s12 m12">
				<div class="card-panel red">
					<span class="white-text">{{ $error }}
					</span>
				</div>
			</div>
		</div>
		@endif
		@if(Session::has('success'))
		<div class="row">
			<div class="col s12 m12">
				<div class="card-panel green">
					<span class="white-text">{{ Session::get('success') }}
					</span>
				</div>
			</div>
		</div>
		@endif
		@if(isset($in_circle))
		<div class="row">
			<div class="col s12 m12">
				<div class="card-panel red">
					<span class="white-text">{{ $in_circle }}
					</span>
				</div>
			</div>
			<div class="col s12 m12">
				@if(Auth::check())
				<a href="{{ url('patient/get/circle/record/' . $record->patient_id) }}" class="right"><button type="button" class="btn waves-effect waves-light"><i class="material-icons right">arrow_back</i> Back</button></a>
				@endif
			</div>
		</div>
		@endif
		@if(isset($record))
		<div class="row">
			<div class="col s12 m12">
				<div class="card-panel white black-text">
					<h3>{{ strtoupper($record->title) }}</h3>
					<hr>
					<h4>Record Details {{ $readonly }}</h4>
					@if(!isset($readonly) && !$readonly == 1)
					<p>
						<input type="checkbox" ng-model="edit" id="test5" />
						<label for="test5">Edit Records</label>
					</p>
					@endif
					<p><b>Timestamp: </b><br> {!! $record->created_at !!}</p>
					<div ng-hide="edit">
						<p><b>Description: </b><br> {!! $record->content !!}</p>
						<div>
							<p><b>Attachments: </b></p>
							<div class="row">
								@if(isset($record->imgs) && count($record->imgs) > 0)
								@foreach($record->imgs as $img)
								<div class="col s3 m3">
									<img class="responsive-img materialboxed" width="650" src="{{ $record->img_url }}"><br>
								</div>
								@endforeach
								@else
								<div class="row">
									<div class="col s12 m12">
										<div class="card-panel red">
											<span class="white-text">No attachment/'s found.
											</span>
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
					@if(!isset($readonly) && !$readonly == 1)
					<div ng-show="edit">
						<div class="row">
							<form action="{{ url('patient/edit/record') }}" class="col s12" method="POST">
								<input type="hidden" value="{{ $record->id }}" name="id" class="validate">
								<div class="row">
									<div class="input-field col s6">
										<input id="Title" type="text" value="{{ $record->title }}" name="title" class="validate">
										<label for="Title">Title</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<textarea id="Description" name="content" class="materialize-textarea">{!! $record->content !!}</textarea>
										<label for="Description">Description</label>
									</div>
								</div>
								{{ csrf_field() }}
								<button type="submit" class="btn waves-effect waves-light">Save Changes</button>
							</form>
						</div>
						<div>
							
						</div>
					</div>
					<p>
						<input type="checkbox" ng-model="attach" id="attach" />
						<label for="attach">Edit Attachments</label>
					</p>
					<div ng-show="attach">
						<form action="{{ url('patient/add/attachment') }}" method="POST" enctype="multipart/form-data">
							<input type="hidden" value="{{ $record->id }}" name="id" class="validate">
							<div class="file-field input-field">
								<div class="btn">
									<span>IMAGES</span>
									<input type="file" name="files[]" multiple required="">
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" type="text" placeholder="Upload one or more images">
								</div>
							</div>
							{{ csrf_field() }}
							
							<button type="submit" class="btn right">ADD ATTACHMENT</button>
						</form>
						<p><b>Attachments: </b></p>
						<div class="row">
							@if(isset($record->imgs) && count($record->imgs) > 0))
							@foreach($record->imgs as $img)
							<div class="col s3 m3">
								<img class="responsive-img materialboxed" width="650" src="{{ $record->img_url }}"><br>
								<center><a href="{{ url('patient/remove/attachment/'.$record->id) }}"><button type="button" class="btn waves-effect waves-light">Remove<i class="material-icons right">remove_circle</i></button></a></center>
							</div>
							@endforeach
							@else
							<div class="row">
								<div class="col s12 m12">
									<div class="card-panel red">
										<span class="white-text">No attachment/'s found.
										</span>
									</div>
								</div>
							</div>
							@endif
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endif		
</div>
</main>
@endsection