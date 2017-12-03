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
				<div class="card-panel green">
					<span class="white-text">{{ Session::get('success') }}
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
									<span class="card-title truncate" style="background-color: #000; width: 100%; opacity: 0.6"><a href="{{ url('patient/record/'. $record->id) }}">{{ $record->title }}</a></span>
									<a ng-click="shareRecord({{ $record->id }})" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">share</i></a>
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
			<h4>Share this Specific Record </h4>
			<p>The key that will be generated here will be used to unlock your data not permanently. This key is disposable. You can set when the key will be destroyed.</p>

			<p><b>Record Title:</b> << record.title  | uppercase>></p>
			<br>

			<div class="input-field"> 
				<div class="form-group">
					<label class="control-label" for="">Assignee</label>
					<input type="text" ng-model="data.assignee" class="form-control" id="" placeholder="Assignee">
				</div>
			</div>
			<div class="input-field"> 
				<div class="form-group">
					<label class="control-label" for="">Recipient Email</label>
					<input type="email" ng-model="data.email" class="form-control" id="" placeholder="Recipient Email">
				</div>
			</div>

			<p>
				Set Key Expiration: The default would be 8 hours before the key expires.
				<input name="group1" type="radio" ng-model="data.duration" value="8" id="8" checked="" />
				<label for="8">8 Hours</label>
				&nbsp;
				<input name="group1" type="radio" ng-model="data.duration" value="48" id="1" />
				<label for="1">1 Day</label>
				&nbsp;
				<input name="group1" type="radio" ng-model="data.duration" value="72" id="3" />
				<label for="3">3 Days</label>
			</p>

			<div class="progress" ng-show="loading">
				<div class="indeterminate"></div>
			</div>
			<p>
				<input type="checkbox" id="show" ng-model="show" />
				<label for="show">Show Key</label>
			</p>
			<div class="input-field" ng-hide="show"> 
				<div class="form-group">
					<label class="control-label" for="">Private Key</label>
					<span class="help-block"></span>
					<input type="password" ng-model="data.key" ng-value="key" placeholder="Private Key" class="form-control" disabled="">
				</div>
			</div>


			<div class="input-field" ng-show="show"> 
				<div class="form-group">
					<label class="control-label" for="">Private Key</label>
					<span class="help-block"></span>
					<input type="text" ng-model="data.key" ng-value="key" placeholder="Private Key" class="form-control" disabled="">
				</div>
			</div>

			<button ng-click="submitKey(data, record.id, key)" class="btn right" ng-disabled="!data.assignee || !data.email">Send and Save</button>
			<br>

			
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
			<form action="{{ url('patient/submit/record') }}" method="POST" enctype="multipart/form-data">
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
						<span>IMAGES</span>
						<input type="file" name="files[]" multiple>
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="Upload one or more images">
					</div>
				</div>
				{{ csrf_field() }}
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