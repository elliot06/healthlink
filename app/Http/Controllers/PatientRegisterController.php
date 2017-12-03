<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use Carbon\Carbon;
use DB;
use App\User;
use App\Models\Patient;

class PatientRegisterController extends Controller
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
			'email' => 'unique:patients|required',
			'name' => 'required',
			'password' => 'confirmed'

		]);

		$unverified = DB::table('users')->where('email', $request['email'])->first();

		if(!$unverified){

			$dta = array (
				'remember_token' => $this->getToken(),
				'name' => htmlentities($request['name']),
				'email' => htmlentities($request['email']),
				'password' => bcrypt($request['password']),
			);

			$content = [
				'button' => 'Confirm Account',
				'url' => env('APP_URL').'confirm/'.$dta['remember_token'].'/'.$dta['email']
			];

			$receiverAddress = $request['email'];

			Mail::send('responses.mail.register', ['content' => $content], function ($m) use ($receiverAddress){
				$m->from('HealthLink@HealthLink.dev', 'HealthLink');

				$m->to($receiverAddress)->subject('Account Confimration');
			});

			$tmp = DB::table('users')->insert($dta);

			if($tmp){
				return view('responses.register_success')->with('data', $dta);
			}
		}else{
			return view('responses.account_confirmed')->with('error', 'error');
		}
	}

	public function accountSetup($token, $email)
	{

		$user = DB::table('users')->where('remember_token', $token)->where('email', $email)->first();

		if($user){
			
			$new = new Patient();
			$new->email = $user->email;
			$new->name = $user->name;
			$new->password = $user->password;
			$new->avatar = $this->get_gravatar($user->email);
			$new->save();

			DB::table('users')->where('remember_token', $token)->where('email', $email)->delete();

			auth()->login($new);

			Session::put('user', $new);

			return view('responses.account_confirmed')->with('user', $user);
		}else{
			return view('responses.account_confirmed')->with('error', 'error');
		}
	}
}
