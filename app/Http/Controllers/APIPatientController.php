<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\PatientProfile;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\SharableKey;
use App\Models\Records;
use App\Models\ActivityLog;

use Auth;
use Input;
use Session;
use Carbon\Carbon;

class APIPatientController extends Controller
{
	public function getToken()
	{
		return response()->json(['token' => Session::token()]);
	}

	function getKey($algo = 'sha256', $length = 1024){
		$key = '';

		if ( function_exists('openssl_random_pseudo_bytes') ){ 

			$data = openssl_random_pseudo_bytes($length, $cstrong) . mt_rand() . microtime();
			$key = hash($algo, $data);
		}else{ 
			$data = mt_rand() . microtime() . file_get_contents('/dev/urandom', $length) . mt_rand() . microtime();
			$key = hash($algo, $data);
		}

		return response()->json(['key' => $key]);
	}

	public function signin(Request $request)
	{
		$email = $request['email'];
		$pass = $request['password'];


		if(Auth::attempt(['email' => $email, 'password' => $pass])){


			$dta = new \stdClass();
			$dta->user = Auth::user();

			Auth::user()->patientName;
			Auth::user()->profile;

			return response()->json(($dta));

		}else{
			return response()->json(['error' => 'Authentication Failed']);
			
			
		}
	}

	public function getAllData(Request $request)
	{
			// return response()->json(['error' => 'Authentication Failed']);
		
		if(Auth::check()){
			$user = Auth::user();
		}else{
			$user = Patient::find($request['id']);
		}

		$requests = array ();
		foreach ($user->getFriendRequests() as $friend) { 
			$dta = Patient::find($friend->id);
			array_push($requests, $dta);
		}

		$friends = array ();
		foreach ($user->getFriends() as $friend) { 
			$dta = Patient::find($friend->id);
			array_push($friends, $dta);
		}

		$records = Records::where('patient_id', $user->id)->orderBy('created_at','DESC')->get();

		$dta = new \stdClass();
		$dta->logs = ActivityLog::where('patient_id', $user->id)->orderBy('created_at','DESC')->get();
		$dta->friends = $friends;
		$dta->records = $records;

		return response()->json(($dta));

	}
}
