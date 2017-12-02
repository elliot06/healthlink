<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});


Route::get('/signin', function () {
	return view('patients.signin');
});

Route::post('/api/signin/account','PatientLoginController@signin');
Route::post('/verify/code','PatientLoginController@verifyCode');

Route::post('api/confirm/domain', 'PatientLoginController@ConfirmEmailDomain');
Route::post('api/send/reset/link', 'PatientLoginController@sendResetLink');
Route::get('domain/{email}/{token}', 'PatientLoginController@confirmedEmail');
Route::post('/change-pass', 'PatientLoginController@changePassword');
Route::post('check/email', 'PatientLoginController@checkEmail');


Route::group(['middleware' => ['web', 'auth']], function () {

	Route::get('/patient/dashboard','PatientController@index');
	Route::get('/patient/records','MedicalRecordsController@index');
	
	Route::get('/patient/signout', 'LoginController@signout');
	Route::post('/patient/sharable/data', 'PatientController@getSharable');
	Route::get('/patient/activity', 'PatientController@getLogs');
	Route::get('/patient/health/circle', 'CircleController@index');
	Route::get('/patient/accept/circle/{id}', 'CircleController@acceptCircle');
	Route::get('/patient/deny/circle/{id}', 'CircleController@denyCircle');
	Route::get('/patient/records', 'MedicalRecordsController@index');
	Route::get('/patient/record/{id}', 'MedicalRecordsController@getRecord');
	Route::post('/patient/submit/record', 'MedicalRecordsController@saveRecord');
	Route::get('/patient/get/circle/record/{id}', 'CircleController@getCircleRecord');
});


Route::group(['middleware' => ['api'],'prefix' => 'api'], function() {

	//REACT ROUTES
	Route::post('/signin', 'APIPatientController@signin');
	Route::get('/token', 'APIPatientController@getToken');

	Route::get('/key', 'APIPatientController@getKey');
	Route::post('/logs', 'ActivityLogController@getLogs');
	Route::post('/data', 'APIPatientController@getAllData');


	//ANGULAR ROUTES
	Route::post('/save/key', 'PatientController@addSharableKey');
	Route::get('/search/{username}', 'CircleController@searchCircle');
	Route::post('/add/circle', 'CircleController@addCircle');
	Route::get('/get/record/{id}', 'MedicalRecordsController@getData');
	Route::post('/edit/record', 'MedicalRecordsController@editRecord');
	Route::get('/notifications', 'PatientController@getNotifications');
});