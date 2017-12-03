@extends('layouts.nonavigation')
@section('title','Account Setup')
@section('controller')
<script type="text/javascript" src="{{ asset('js/controllers/AccountSetupController.js') }}"></script>
@endsection
@section('content')
<div class="container" ng-controller="accountSetup">
	<div class="row center">
		<div class="col s12 m8 offset-m2 l8 offset-l2">
			<h3>Hi {{ Auth::user()->name }}, Welcome to HealthLink! Before you continue, let us setup your account.</h3>
		</div>
	</div>

	<div class="row">
		<div class="col s12 m12 l12">

			<form action="{{ url("post/account/setup") }}" method="POST">
				<ul class="stepper linear" style="min-height:720px" name="feedbacker">
					<li class="step active">
						<div class="step-title waves-effect">Personal Information</div>
						<div class="step-content">
							<div class="row">
								<div class="card white darken-1">
									<div class="card-content black-text">
										<div class="row">
											<div class="col s12">
												<div class="row">
													<div class="input-field col s12 m3 l3">
														<input name="last_name" id="last_name" type="text" class="validate" required>
														<label for="name">Last Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="first_name" id="first_name" type="text" class="validate" required>
														<label for="first_name">First Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="middle_name" id="middle_name" type="text" class="validate">
														<label for="middle_name">Middle Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="ext_name" id="ext_name" type="text" class="validate">
														<label for="ext_name">Name Extension (e.g Jr., II)</label>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col s12">
												<div class="row">
													<div class="input-field col s12 m2 l2">
														<select name="gender" required>
															<option value="" disabled selected>Gender</option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>
														</select>
														<label>Gender</label>
													</div>
													<div class="input-field col s12 m1 l1">
														<input type="number" name="age" class="validate" required="">
														<label for="datepicker">Age</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input type="date" name="birthdate" class="datepicker" required="">
														<label for="datepicker">Birthdate</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="birth_place" type="text" class="validate" required>
														<label for="birth_place">Place of Birth</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="citizenship" type="text" class="validate" required>
														<label for="citizenship">Citizenship</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="step-actions">
								<button class="waves-effect waves-dark cyan btn next-step">CONTINUE</button>
							</div>
						</div>
					</li>
					<li class="step">
						<div class="step-title waves-effect">Address Details</div>
						<div class="step-content">
							<div class="row">
								<div class="card white darken-1">
									<div class="card-content black-text">
										<div class="row">
											<div class="col s12">
												<h6>Permanent Home Address</h6>
												<div class="row">
													<div class="input-field col s12 m12 l12">
														<input name="perma_address" type="text" class="validate" ng-model="perma_address" required>
														<label for="perma_address">Address</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="perma_city" type="text" class="validate" ng-model="perma_city" required>
														<label for="perma_city">City</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="perma_province" type="text" class="validate" ng-model="perma_province" required>
														<label for="perma_province">Province</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="perma_region" type="text" class="autocomplete validate" id="auto-region" ng-model="perma_region" required>
														<label for="perma_region">Region</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="perma_postal" type="text" class="validate" ng-model="perma_postal" required>
														<label for="perma_postal">Postal Code</label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12">
												<h6>Present Home Address </h6>
												<input type="checkbox" id="sameAddress" ng-model="sameAddress" name="same" value="1" />
												<label for="sameAddress">Same as Permanent Home Address</label>
												<div class="row" ng-show="sameAddress">
													<div class="input-field col s12 m12 l12">
														<input disabled="" type="text" class="validate" placeholder="Address" value="<< perma_address >>" required>
														<label for="pres_address">Address</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input disabled="" type="text" class="validate" placeholder="City" value="<< perma_city >>" required>
														<label for="perma_city">City</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input disabled="" type="text" class="validate" placeholder="Province" value="<< perma_province >>" required>
														<label for="pres_province">Province</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input disabled="" type="text" class="validate" placeholder="Region" value="<< perma_region >>" required>
														<label for="pres_region">Region</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input disabled="" type="text" class="validate" placeholder="Postal Code" value="<< perma_postal >>" required>
														<label for="pres_postal">Postal Code</label>
													</div>
												</div>
												<div class="row" ng-hide="sameAddress">
													<div class="input-field col s12 m12 l12">
														<input name="pres_address" type="text" class="validate" value="" required>
														<label for="pres_address">Address</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="pres_city" type="text" class="validate" required>
														<label for="perma_city">City</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="pres_province" type="text" class="validate" required>
														<label for="pres_province">Province</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="pres_region" type="text" class="autocomplete validate" id="auto-region" required>
														<label for="pres_region">Region</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="pres_postal" type="text" class="validate" required>
														<label for="pres_postal">Postal Code</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="step-actions">
								<button class="waves-effect waves-dark cyan btn next-step">CONTINUE</button>
								<button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
							</div>
						</div>
					</li>
					<li class="step">
						<div class="step-title waves-effect">Contact Information</div>
						<div class="step-content">
							<div class="row">
								<div class="col s12">
									<h6>Contact</h6>
									<div class="row">
										<div class="input-field col s12 m3 l3">
											<input name="home_contact" type="text" class="validate" required>
											<label for="home_contact">Home</label>
										</div>
										<div class="input-field col s12 m3 l3">
											<input name="cell_contact" type="text" class="validate" required>
											<label for="cell_contact">Cell Phone</label>
										</div>
										<div class="input-field col s12 m3 l3">
											<input name="email" type="text" class="validate" value="{{ Auth::user()->email }}">
											<label for="email">Email Address</label>
										</div>
										<div class="input-field col s12 m3 l3">
											<input name="neighborhood_contact" type="text" class="validate">
											<label for="neighborhood_contact">Neighborhood Contact</label>
										</div>
									</div>
								</div>
							</div>
							<div class="step-actions">
								<button class="waves-effect waves-dark cyan btn next-step">CONTINUE</button>
								<button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
							</div>
						</div>
					</li>
					<li class="step">
						<div class="step-title waves-effect">Family Background</div>
						<div class="step-content">
							<div class="row">
								<div class="card white darken-1">
									<div class="card-content black-text">
										<div class="row">
											<div class="col s12">
												<h6>Mother's Information</h6>
												<small>Mother's Maiden Name</small>
												<div class="row">
													<div class="input-field col s12 m3 l3">
														<input name="m_lname" type="text" class="validate" required>
														<label for="m_lname">Last Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="m_fname" type="text" class="validate" required>
														<label for="m_fname">First Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="m_mname" type="text" class="validate" required>
														<label for="m_mname">Middle Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="m_citizenship" type="text" class="validate" required>
														<label for="m_citizenship">Citizenship</label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12">
												<div class="row">
													<div class="input-field col s12 m3 l3">
														<input name="m_contact" type="text" class="validate" required>
														<label for="m_contact">Contact Number</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="m_email" type="email" class="validate" required>
														<label for="m_email">Email Address</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="m_occupation" type="text" class="validate" required>
														<label for="m_occupation">Occupation</label>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col s12">
												<h6>Father's Information</h6>
												<div class="row">
													<div class="input-field col s12 m3 l3">
														<input name="f_lname" type="text" class="validate" required>
														<label for="f_lname">Last Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="f_fname" type="text" class="validate" required>
														<label for="f_fname">First Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="f_mname" type="text" class="validate" required>
														<label for="f_mname">Middle Name</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="f_citizenship" type="text" class="validate" required>
														<label for="f_citizenship">Citizenship</label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col s12">
												<div class="row">
													<div class="input-field col s12 m3 l3">
														<input name="f_contact" type="text" class="validate" required>
														<label for="f_contact">Contact Number</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="f_email" type="email" class="validate" required>
														<label for="f_email">Email Address</label>
													</div>
													<div class="input-field col s12 m3 l3">
														<input name="f_occupation" type="text" class="validate" required>
														<label for="f_occupation">Occupation</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="step-actions">
								<button class="waves-effect waves-dark cyan btn next-step">CONTINUE</button>
								<button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
							</div>
						</div>
					</li>
					<li class="step">
						<div class="step-title waves-effect">Statistics Information</div>
						<div class="step-content">
							<div class="row">
								<div class="col s12">
									<h6>Just some Health Statistics</h6>
									<div class="row">
										<div class="input-field col s12 m3 l2">
											<input name="height" type="text" class="validate" ng-model="height" placeholder="" required>
											<label for="height">Height (m)</label>
										</div>
										<div class="input-field col s12 m3 l2">
											<input name="weight" type="text" class="validate" ng-model="weight" ng-keyup="mybmi()" required>
											<label for="weight">Weight (kg)</label>
										</div>
										<div class="input-field col s12 m3 l2">
											<input name="bmi" disabled="" type="text" class="validate" value="<< bmi >>" placeholder="Body Mass Index" required>
											<input name="bmi" type="hidden" class="validate" value="<< bmi >>" required>
											<label for="bmi">Body Mass Index</label>
										</div>
										<div class="input-field col s12 m3 l3">
											<input name="bmi_category" disabled="" type="text" class="validate" value="<< category >>" placeholder="Body Mass Index" required>
											<input name="bmi_category" type="hidden" class="validate" value="<< category >>" required>
											<label for="bmi">BMI Category</label>
										</div>
										<div class="input-field col s12 m3 l2">
											<select name="blood_type">
												<option value="" disabled selected>Blood Type</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="AB">AB</option>
												<option value="O">O</option>
											</select>
											<label>Blood Type</label>
										</div>
									</div>
								</div>
							</div>
							<div class="step-actions">
								<!-- <button class="waves-effect waves-dark btn next-step">CONTINUE</button> -->
								{{ csrf_field() }}
								<button type="submit" class="waves-effect cyan waves-dark pulse btn">Submit</button>
								<button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
							</div>
						</div>
					</li>
				</ul>
			</form>

			

			



		</div>
	</div>
	@endsection