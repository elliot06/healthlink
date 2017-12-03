<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use Carbon\Carbon;
use DB;
use App\User;
use App\Models\Doctor;
use App\Models\SharableKey;
use App\Models\Patient;
use App\Models\MedicalRecords;

use Auth;
use App\Http\Controllers\ActivityLogController;

class DoctorController extends Controller
{
	public function getToken()
	{
		return hash_hmac('sha256', env('APP_KEY'), 40);
	}

	public function get_gravatar( $email, $s = 256, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
		$url = 'https://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";

		return $url;
	}

	public function index(Request $request)
	{
		
		$this->validate($request,[
			'email' => 'unique:doctors|required',
			'name' => 'required',
			'password' => 'confirmed'

		]);

		$unverified = DB::table('dr_tmp')->where('email', $request['email'])->first();
		// return dd($request->all());
		if(!$unverified){

			$dta = array (
				'remember_token' => $this->getToken(),
				'name' => htmlentities($request['name']),
				'email' => htmlentities($request['email']),
				'password' => bcrypt($request['password']),
			);

			$content = [
				'button' => 'Confirm Account',
				'url' => env('APP_URL').'confirm/doctor/'.$dta['remember_token'].'/'.$dta['email']
			];

			$receiverAddress = $request['email'];

			Mail::send('responses.mail.register', ['content' => $content], function ($m) use ($receiverAddress){
				$m->from('HealthLink@HealthLink.dev', 'HealthLink');

				$m->to($receiverAddress)->subject('Account Confimration');
			});

			$tmp = DB::table('doctors')->insert($dta);

			if($tmp){
				return view('responses.register_success')->with('data', $dta);
			}
		}else{
			return view('responses.account_confirmed')->with('error', 'error');
		}
	}

	public function accountSetup($token, $email)
	{

		$user = DB::table('dr_tmp')->where('remember_token', $token)->where('email', $email)->first();

		if($user){
			
			$new = new Doctor();
			$new->email = $user->email;
			$new->name = $user->name;
			$new->password = $user->password;
			$new->avatar = $this->get_gravatar($user->email);
			$new->save();

			DB::table('dr_tmp')->where('remember_token', $token)->where('email', $email)->delete();

			if(Auth::guard('doctor')->attempt(['email' => $request['email'], 'password' => $request['password']])){
				return view('responses.account_confirmed')->with('user', $new);
			}
		}else{
			return view('responses.account_confirmed')->with('error', 'error');
		}
	}

	public function signin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|max:255',
			'password' => 'required',
		]);

		if (Auth::guard('doctor')->attempt(['email' => $request['email'], 'password' => $request['password']])) {
			return redirect('doctor/dashboard');
		}else{
			return redirect()->back()->with('error', 'Invalid Credentials.');
		}

	}

	public function signout()
	{	
		if(Auth::guard('doctor')->check()){
			Auth::guard('doctor')->logout();
			return redirect('/')->header('Clear-Site-Data','cache','storage','executionContexts');
		}
	}

	public function getDashboard()
	{
		
		return view('doctors.dashboard');
	}

	public function getSharable(Request $request)
	{
		$dta = $request->all();

		$sharable = SharableKey::where('private_key', $dta['key'])->first();

		Session::forget('key');
		if($sharable){
			if($sharable->delete_on <= Carbon::now()){
				return view('sharable')->with('expire', 'expired');
			}else{
				Session::put('key', htmlentities($dta['key']));
				if($sharable->record_id != null){
					$record = MedicalRecords::with('imgs')->find($sharable->record_id);
					if(Auth::guard('doctor')->check() && isset($record)){
						if(Session::has('key')){
						// dd($record);
							$user = Patient::find($record->patient_id);

							$message = Auth::guard('doctor')->user()->name." used the shareable key you've sent via email.";
							ActivityLogController::saveLog($record->patient_id,$message);
							return view('patients.record_data')->with(['record'=> $record, 'readonly' => '1', 'in_circle' => 'You are currently viewing one of'. $user->profile->first_name . ' ' . $user->profile->last_name . '\'s health records']);
						}else{
							return redirect('doctor/dashboard');
						}

					}else{
						return redirect('doctor/dashboard');
					}
				}else{

					$user = Patient::find($sharable->patient_id);
					Session::put('key', htmlentities($dta['key']));

					$message = Auth::guard('doctor')->user()->name." used the shareable key you've sent via email.";
					ActivityLogController::saveLog($sharable->patient_id,$message);
					return view('doctors.dashboard')->with('friend', $user);
				}
			}
		}else{
			return view('doctors.dashboard')->with('error', 'We cannot validate the private key you entered. Please make sure that your place the right key that was sent to you.');
		}
	}
}
