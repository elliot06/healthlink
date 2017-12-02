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

use App\Mail\SendVerificationCode;

use Auth;
use Input;
use Session;
use Carbon\Carbon;
use Mail;

class PatientLoginController extends Controller
{
	protected function getToken()
	{
		return hash_hmac('sha256', str_random(40), config('app.key'));
	}

	public function checkEmail(Request $request)
	{
		if(Patient::where('email', htmlentities($request["email"]))->exists()){
			return 'exist';
		}else{
			return 'available';
		}
	}

	public function signin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|max:255',
			'password' => 'required',
		]);

		if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
			Session::put('code', $this->verificationCode());

			$content = [
				'fname'       => Auth::user()->profile->first_name,
				'code'       => Session::get('code'),
			];
			Mail::to(Auth::user()->email)->send(new SendVerificationCode($content));
			return 'valid';
		}else{
			return 'Invalid Login Credentials.';
		}

		return redirect()->back();
	}

	protected function verificationCode()
	{
		return str_random(10);
	}

	public function verifyCode(Request $request)
	{
		if($request['code'] == Session::get('code')){
			return redirect('/patient/dashboard');
		}else{
			Auth::logout();
			return redirect('/');
		}
	}

	

	public function changePassword(Request $request)
	{
		if(Auth::check()){
			$this->validate($request,[
				'password' => 'required|min:8|confirmed',
			]);
			
			$user = Auth::user();
			$user->password = bcrypt($request['password']);
			$user->save();

			
			return Redirect::to('/dashboard')->with('success', 'Your password was successfully changed.');

		}else{
			return view('errors.401');
		}
	}

	public function signout()
	{	
		if(Auth::check()){
			Auth::logout();
			return redirect('/')->header('Clear-Site-Data','cache','storage','executionContexts');
		}
	}

	public function ConfirmEmailDomain(Request $request)
	{
		// return $request['email'];
		$reset = new Resets();
		$reset->email = htmlentities($request['email']);
		$reset->token = $this->getToken();
		$reset->created_at = Carbon::now();
		$reset->save();

		$content = [
			'url'         => env('APP_URL').'/domain/'.$reset->email.'/'.$reset->token,
			'email'       => htmlentities($request['email']),
		];

		Mail::to($request['email'])->send(new ConfirmEmailDomain($content));

		if (count(Mail::failures()) > 0) {
			return 'unsent';
		}else{
			return 'sent';	
		}
	}

	public function confirmedEmail($email, $token)
	{
		$resets = Resets::where('email', $email)->where('token', $token)->first();

		if($resets){
			$company = Company::where('email', $email)->first();

			Session::put('domain', $company->website_url);
			
			$resets->delete();
			return Redirect::to('signin');
		}else{
			return view('errors.404');
		}
	}
}
