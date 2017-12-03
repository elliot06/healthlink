<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use Response;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\profile;
use App\Models\PatientProfile;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\SharableKey;
use App\Models\Notifcations;

use App\Http\Requests;
use App\Http\Controllers\ActivityLogController;

class CircleController extends Controller
{

	public function index()
	{
		$user = Auth::user();

		if(isset($user->circle)){
			$remaining = $user->circle->total;
		}else{
			$remaining = 3;
		}

		if($user->getFriendsCount() == 0){

			$requests = array ();
			foreach ($user->getFriendRequests() as $friend) { 
				$dta = Patient::find($friend->sender_id);
				array_push($requests, $dta);
			}

			$remaining = $remaining - $user->getFriendsCount();

			return view('patients.circle')->with([
				'friends' => $user->getFriendsCount(),
				'requests' => $requests,
				'remaining' => $remaining,
			]);
		}elseif(count($user->getFriendRequests()) > 0){
			$requests = array ();
			foreach ($user->getFriendRequests() as $friend) { 
				$dta = Patient::find($friend->sender_id);
				array_push($requests, $dta);
			}

			$remaining = $remaining - $user->getFriendsCount();

			$friends = array ();
			foreach ($user->getFriends() as $friend) { 
				$dta = Patient::find($friend->id);
				array_push($friends, $dta);
			}

			return view('patients.circle')->with([
				'requests' => $requests,
				'friends' => $friends,
				'remaining' => $remaining,
			]);
		}else{

			$friends = array ();
			foreach ($user->getFriends() as $friend) { 
				$dta = Patient::find($friend->id);
				array_push($friends, $dta);
			}

			$remaining = $remaining - $user->getFriendsCount();

			return view('patients.circle')->with([
				'friends' => $friends,
				'remaining' => $remaining,
			]);
		}

	}

	public function searchCircle($username)
	{
		$results = Patient::with('profile')->where('name', 'LIKE', '%'.$username.'%')->get();

		return Response::json($results);
	}

	public function getPendingCircle()
	{
		$user = Auth::user();

		$user->getFriendRequests();
	}

	public function addCircle(Request $request)
	{
		if(Auth::check()){
			$user = Auth::user();
		}else{
			$user = Patient::find($request['id']);
		}

		$recipient = Patient::find($request['recipient']);

		if($user->isFriendWith($recipient)){
			return 'isFriend';
		}elseif($user->hasSentFriendRequestTo($recipient)){
			return 'isPending';
		}else{
			$message = "You sent a request to ".$recipient->profile->last_name.", ".$recipient->profile->first_name.".";
			ActivityLogController::saveLog($user->id,$message);

			if($user->befriend($recipient)){
				$notification = new Notifcations();
				$notification->person_id = $recipient->id;
				$notification->content = $user->name." wants to be in a circle with you.";
				$notification->is_notified = 0;
				$notification->save();
			}

			return 'requestSent';
		}
	}

	public function acceptCircle($sender)
	{
		$user = Auth::user();
		$recipient = Patient::find($sender);
		$user->acceptFriendRequest($recipient);

		$message = "You accepted the request of ".$recipient->profile->last_name.", ".$recipient->profile->first_name.".";
		ActivityLogController::saveLog($user->id,$message);

		return redirect('patient/health/circle')->with('accepted', 'Request has been accepted.');
	}

	public function denyCircle($sender)
	{
		$user = Auth::user();
		$recipient = Patient::find($sender);
		$user->denyFriendRequest($recipient);

		$message = "You denied the request of ".$recipient->profile->last_name.", ".$recipient->profile->first_name.".";
		ActivityLogController::saveLog($user->id,$message);

		return redirect('patient/health/circle')->with('denied', 'Request has been accepted.');
	}

	public function getCircleRecord($id)
	{
		$user = Auth::user();
		$friend = Patient::find($id);

		if($user->isFriendWith($friend)){

			$dta = Patient::find($id);

			return view('patients.circle_data')->with('friend', $dta);
		}
	}
}
