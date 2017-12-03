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
use Validator;
use Hash;
use JWTAuth;
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

	/**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'unique:patients',
            'email' => 'unique:patients',
        ];
        $input = $request->only('name', 'email');
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $username = $request->name;
        $email = $request->email;
        $password = $request->password;
        $user = Patient::create(['name' => $username, 'email' => $email, 'password' => Hash::make($password)]);
        return $this->login($request);
	}
	
	/**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]]);
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }
}
