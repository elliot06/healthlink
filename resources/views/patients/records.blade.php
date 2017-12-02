@extends('layouts.master')
@section('title','Records')
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/PatientController.js') }}"></script>
@endsection
@section('content')
<main ng-controller="records">
	<div class="container-fluid">
		<div class="row">
			<div class="col col s12 m12 l12" >
				<h3>Health Records <small>You list of uploaded health documents.</small></h3>
			</div>
		</div>
		@if(Session::has('success'))
		<div class="row">
			<div class="col s12 m12">
				<div class="card-panel teal">
					<span class="white-text">I am a very simple card. I am good at containing small bits of information.
						I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
					</span>
				</div>
			</div>
		</div>
		@endif

		@if(isset($records) && count($records) == 0)
		<div class="row">
			<div class="col s12 m12 l12">
				<div class="card-panel cyan ">
					<span class="white-text"><i class="material-icons left">info</i> You don't have any uploaded records yet. You can upload through the button below.
					</span>
				</div>
			</div>
		</div>
		@else
		@if(isset($records) && count($records) > 0)
		<div class="row">
			<div class="col s12 m12 l12">
				<div class="card-panel white">
					<div class="row">
						@foreach($records as $record)
						<div class="col s12 m3 l3">
							<div class="card">
								<div class="card-image">
									<img style="height: 350px" src="{{ $record->img_url }}">
									<span class="card-title truncate" style="background-color: #000; width: 100%; opacity: 0.6">{{ $record->title }}</span>
									<a ng-click="getData({{ $record->id }})" class="btn-floating halfway-fab waves-effect waves-light green"><i class="material-icons">visibility</i></a>
								</div>
								<div class="card-content">
									<p class="truncate">
										@if(count($record->tags) > 0)
										@foreach($record->tags as $tag)
										@if(isset($tag))
										<div class="chip">
											{{ $tag->name }}
										</div>
										@else
										@endif
										@endforeach
										@else
										<div class="chip">
											No tags
										</div>
										@endif
									</p>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif
		@endif
	</div>

	<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
		<a class="modal-trigger" href="#addRecord"><button type="button" class="btn-floating btn-large red pulse">
			<i class="large material-icons">add</i></button></a>
		</button>
	</div>

	<!-- Modal Trigger -->
	
	<!-- Modal Structure -->
	<div id="dataView" class="modal">
		<div class="modal-content">
			<h4 ng-hide="edit"><< data.title >></h4>
			<input type="hidden" ng-model="data.id" value="<< data.id >>">
			<div class="input-field" ng-show="edit"> 
				<div class="form-group">
					<label class="control-label" for="">Title</label>
					<span class="help-block"></span>
					<input type="text" class="form-control" id="" ng-model="data.title" value="<< data.title >>" placeholder="Title">
				</div>
			</div>
			<div class="input-field" ng-show="edit">
				<textarea id="textarea1" class="materialize-textarea" ng-model="data.content" placeholder="Content"><< data.content >></textarea>
				<label for="textarea1">Content</label>
			</div>

			<p><b>Timestamp:</b> << data.created_at >>
				<small class="right">
					<input type="checkbox" id="edit" ng-model="edit"/>
					<label for="edit">Edit Mode</label>
				</small>
			</p>
			
			<p ng-hide="edit"><b>Content:</b> << data.content >></p>
			<a href="<< img.img_url >>" data-lightbox="image-1" data-title="<< data.title >>" ng-repeat="img in data.imgs" style="margin: 10px;"><img src="<< img.img_url >>"  style="width: 220px; height: 250px; padding: 10px; border: 1px solid #000"></a>
			
		</div>
		<div class="modal-footer">
			<a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Close</a>
			<a ng-click="save(data)" class="waves-effect waves-green btn-flat modal-action" ng-show="edit">save changes</a>
		</div>
	</div>

	<!-- Modal Trigger -->
	
	<!-- Modal Structure -->
	<div id="addRecord" class="modal">
		<div class="modal-content black-text">
			<h4 class="black-text">Add Record</h4>
			<p class="black-text">You can add your records to your vault. </p>

			<br>
			<form action="{{ url('submit/record') }}" method="POST" enctype="multipart/form-data">
				<div class="input-field"> 
					<div class="form-group">
						<label class="control-label" for="">Record Title</label>
						<span class="help-block"></span>
						<input type="text" class="form-control" name="title" id="" placeholder="Your title here .." required="">
					</div>
				</div>

				<div class="input-field">
					<textarea id="textarea1" name="content" class="materialize-textarea" placeholder="Some of your content here ..." required=""></textarea>
					<label for="textarea1">Description</label>
				</div>

				<span>Enter some tags</span>
				<div class="chips chips-placeholder" id="tag"></div>
				<div id="tags">
					
				</div>

				<div class="file-field input-field">
					<div class="btn">
						<span>File</span>
						<input type="file" name="files[]" multiple>
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="Upload one or more files">
					</div>
				</div>
				
				<button type="submit" class="btn waves-effect waves-light right"><i class="material-icons right">send</i>Add to Vault</button>
				<br>
			</form>
		</div>

		<div class="modal-footer">
			<a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Close</a>
		</div>
	</div>

</main>

@endsection