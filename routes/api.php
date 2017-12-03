<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::post('register', 'APIPatientController@register');
Route::post('login', 'APIPatientController@login');
// Route::post('recover', 'AuthController@recover');

Route::group(['middleware' => ['jwt.auth']], function() {
	Route::get('logout', 'APIPatientController@logout');
	Route::get('getAll', 'APIPatientController@getAllData');
	Route::post('/save/key', 'APIPatientController@addSharableKey');
	Route::post('/sharable/data', 'APIPatientController@getSharable');
	Route::post('/key', 'APIPatientController@getKey');
});
