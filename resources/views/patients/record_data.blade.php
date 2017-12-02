@extends('layouts.master')
@section('title', isset($record) ? $record->title:'Forbidden')
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/PatientController.js') }}"></script>
@endsection
@section('content')
<main ng-controller="records">
	<div class="container-fluid">
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
		@if(isset($record))
		<div class="row">
			<div class="col s12 m12">
				<div class="card-panel white black-text">
					<h3>{{ strtoupper($record->title) }}</h3>
					<hr>
					<h4>Record Details</h4>
					<p><b>Timestamp: </b><br> {!! $record->created_at !!}</p>
					<p><b>Description: </b><br> {!! $record->content !!}</p>
					<div><p><b>Attachments: </b></p>
						<div class="row">
							@if(isset($record->imgs) && count($record->imgs) > 0))
							@foreach($record->imgs as $img)
							<div class="col s3 m3">
								<img class="responsive-img materialboxed" width="650" src="{{ $record->img_url }}">
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
			</div>
		</div>
	</div>
	@endif		
</div>
</main>
@endsection