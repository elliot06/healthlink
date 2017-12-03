<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;
use App\Models\PatientProfile;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\SharableKey;
use App\Models\MedicalRecords;
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

	public function getAllData(Request $request)
	{
		
        try {

		if (! $user = JWTAuth::parseToken()->authenticate()) {
			return response()->json(['user_not_found'], 404);
		}

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        $users = response()->json(compact('user'));

        $patient = Patient::where('id', Auth::user()->id)->get()->first();

		$requests = array ();
		foreach ($patient->getFriendRequests() as $friend) { 
			$dta = Patient::find($friend->id);
			array_push($requests, $dta);
		}

		$friends = array ();
		foreach ($patient->getFriends() as $friend) { 
			$dta = Patient::find($friend->id);
			array_push($friends, $dta);
		}

		$records = MedicalRecords::where('patient_id', $patient->id)->orderBy('created_at','DESC')->get();

		$dta = new \stdClass();
		$dta->logs = ActivityLog::where('patient_id', $patient->id)->orderBy('created_at','DESC')->get();
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
            'name' => 'unique:required',
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

        $user = Patient::where('email', $request->email)->get()->first();

        if (empty($user))
        {
            return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 401);
        }

        $current_password = $user->password;

        if(!Hash::check($request->password, $current_password))
        {
            return response()->json(['success' => false, 'error' => 'Authentication failed.'], 401);
        }
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }

        $p = Patient::where('email', $request->email)->get()->first();
        $p->profile;
        // all good so return the token
        return response()->json(['success' => true, 'name' => $p->profile->full_name(),
        'cell_no' => $p->profile->cell_contact, 'gender' => $p->profile->gender,
        'age' => $p->profile->age, 'birthdate' => $p->profile->birthdate, 'email' => $p->email, 'data'=> [ 'token' => $token ]]);
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

    public function addSharableKey(Request $request)
	{
		
		try {
            
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            
                return response()->json(['token_expired'], $e->getStatusCode());
            
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            
                return response()->json(['token_invalid'], $e->getStatusCode());
            
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            
                return response()->json(['token_absent'], $e->getStatusCode());
            
            }
            
                    // the token is valid and we have found the user via the sub claim
            $users = response()->json(compact('user'));
            
        $patient = Patient::where('id', Auth::user()->id)->get()->first();

		$unused = SharableKey::where('recipient_mail', $request['email'])->where('patient_id', $patient->id)->first();

		if($unused){
			return response()->json(['result' => 'Key is still valid.']);
		}
        
		$dta = $request->all();

		$duration = '';

		if(!isset($dta['duration'])){
			$duration = 8;
		}else{
			$duration = $dta['duration'];
        }
        
        $key_value = $this->getKey();

		$content = [
			'key'=> $key_value, 
			'name'=> $request->name,
			'sender'=> $patient->profile->first_name.' '.$patient->profile->last_name,
			'duration'=> $duration,
			'url'=> env('APP_URL').'sharable',
		];

		$receiverAddress = $request['email'];

		Mail::send('responses.mail.key', ['content' => $content], function ($m) use ($receiverAddress){
			$m->from('healthchain@healthchain.dev', 'HealthChain');

			$m->to($receiverAddress)->subject('Private Key');
		});

		$SharableKey = new SharableKey();
		$SharableKey->patient_id = $patient->id;
		$SharableKey->recipient_name = $request->name;
		$SharableKey->recipient_mail = $request->email;
		$SharableKey->private_key = $key_value;
		$SharableKey->delete_on = Carbon::now()->addHour($duration);
		$SharableKey->created_at = Carbon::now();
		$SharableKey->save();

		$message = "You generated a key for ".$dta['name']." that was sent to ".$dta['email'].".";
		ActivityLogController::saveLog($user->id,$message);
		return response()->json(['result' => 'Key has been save and sent.']);
		
	}

	public function getSharable(Request $request)
	{

        try {
            
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            
                return response()->json(['token_expired'], $e->getStatusCode());
            
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            
                return response()->json(['token_invalid'], $e->getStatusCode());
            
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            
                return response()->json(['token_absent'], $e->getStatusCode());
            
            }
            
                    // the token is valid and we have found the user via the sub claim
            $users = response()->json(compact('user'));
            
        $patient = Patient::where('id', Auth::user()->id)->get()->first();

		$dta = $request->all();

		$sharable = SharableKey::where('private_key', $dta['key'])->first();

		if($sharable){
			if($sharable->delete_on <= Carbon::now()){
				return view('sharable')->with('expire', 'expired');
			}
			$patient = Patient::find($sharable->patient_id);

			return view('sharable')->with('friend', $patient);
		}else{
			return view('sharable')->with('undefined', 'undefined');
		}
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

		return response()->json(['success' => true]);
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
