<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ActivityLogController;

use Auth;
use Mail;
use Response;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\PatientName;
use App\Models\PatientProfile;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\SharableKey;
use App\Models\Notification;
use App\Models\ActivityLog;
use App\Models\MedicalRecords;
use App\Models\Tags;

use Charts;
use Session;

class PatientController extends Controller
{
public function getToken()
	{
		return hash_hmac('sha256', env('APP_KEY'), 40);
	}

	public function index()
	{	
		$user = Auth::user();
		$MedicalRecords = MedicalRecords::with('imgs')->where('patient_id',$user->id)->orderBy('created_at', 'DESC')->LIMIT(4)->get();
		$requests = array ();
		$friends = array ();

		if($user->getFriendsCount() == 0){
			foreach ($user->getFriendRequests() as $friend) { 
				$dta = Patient::find($friend->sender_id);
				array_push($requests, $dta);
			}

		}

		if(count($user->getFriendRequests()) > 0){
			foreach ($user->getFriendRequests() as $friend) { 
				$dta = Patient::find($friend->sender_id);
				array_push($requests, $dta);
			}


		}
		
		if(count($user->getFriends()) > 0){
			foreach ($user->getFriends() as $friend) { 
				$dta = Patient::find($friend->id);
				array_push($friends, $dta);
			}
		}
		$tagg = Tags::select('name')->distinct()->get();

		$tagCount = array ();
		$tagLabel = array ();

		foreach ($tagg as $tag) {
			$num = Tags::where('name', $tag->name)->count();

			array_push($tagCount, $num);
			array_push($tagLabel, $tag->name);
		}

		$tags =  Charts::create('pie', 'google')
		->title('Your Record Tags')
		->labels($tagLabel)
		// ->colors();
		->values($tagCount)
		->dimensions(900,450)
		->responsive(false);

		$data = MedicalRecords::where('patient_id', Auth::user()->id);
		$overview = Charts::database($data->get(),'area', 'highcharts')
		->title('Number of MedicalRecords per month')
		->elementLabel('MedicalRecords')
		->colors(['#009688'])
		// ->labels($data->pluck('created_at'))
		// ->values($data)
		->dimensions(900,450)
		// ->responsive(true)
		->groupByMonth();

		return view('patients.dashboard')->with([
			'requests' => $requests,
			'friends' => $friends,
			'MedicalRecords' => $MedicalRecords,
			'tags' => $tags,
			'overview' => $overview
		]);
	}

	public function addSharableKey(Request $request)
	{
		
		if(Auth::check()){
			$user = Auth::user();
		}else{
			$user = Patient::find($request['id']);
		}

		$unused = SharableKey::where('recipient_mail', $request['email'])->where('patient_id', $user->id)->first();

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

		$content = [
			'key'=> $dta['key'], 
			'name'=> $dta['assignee'],
			'sender'=> $user->profile->first_name.' '.$user->profile->last_name,
			'duration'=> $duration,
			'url'=> env('APP_URL').'sharable',
		];

		$receiverAddress = $request['email'];

		Mail::send('responses.mail.key', ['content' => $content], function ($m) use ($receiverAddress){
			$m->from('HealthLink@HealthLink.dev', 'HealthLink');

			$m->to($receiverAddress)->subject('Private Key');
		});

		$SharableKey = new SharableKey();
		$SharableKey->patient_id = $user->id;
		$SharableKey->recipient_name = $dta['assignee'];
		$SharableKey->recipient_mail = $dta['email'];
		$SharableKey->private_key = $dta['key'];
		$SharableKey->delete_on = Carbon::now()->addHour($duration);
		$SharableKey->created_at = Carbon::now();
		$SharableKey->save();

		$message = "You generated a key for ".$dta['assignee']." that was sent to ".$dta['email'].".";
		ActivityLogController::saveLog($user->id,$message);
		return response()->json(['result' => 'Key has been save and sent.']);
		
	}

	public function getSharable(Request $request)
	{
		$dta = $request->all();

		$sharable = SharableKey::where('private_key', $dta['key'])->first();

		if($sharable){
			if($sharable->delete_on <= Carbon::now()){
				return view('sharable')->with('expire', 'expired');
			}
			$user = Patient::find($sharable->patient_id);

			return view('sharable')->with('friend', $user);
		}else{
			return view('sharable')->with('undefined', 'undefined');
		}
	}

	public function deleteSharable()
	{
		Session::forget('success');
		Session::forget('error');
		$sharables = SharableKey::where('delete_on', '<=', Carbon::now())->get();

		foreach ($sharables as $sharable) {
			$up = SharableKey::find($sharable->id);
			$up->delete();
			$up->save();
		}

		return 'success';
	}

	public function getNotifications()
	{
		$notifs = Notification::where('is_notified', 0)->where('patient_id', Auth::user()->id)->orderBy('created_at','DESC')->get();
		$user = Auth::user();

		if(count($notifs) > 0 || count($user->getFriendRequests()) > 0){
			foreach ($notifs as $notif) {
				$up = Notification::find($notif->id);
				$up->is_notified = 1;
				$up->save();
			}
			return Response::json(['notifs' => $notifs, 'pending' => $user->getFriendRequests()]);
		}
	}

	public function getLogs()
	{
		$logs = ActivityLog::where('patient_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

		return view('patient.logs')->with('activities', $logs);
	}
}
