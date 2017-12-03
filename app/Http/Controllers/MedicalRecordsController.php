<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use Response;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\PatientProfile;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\SharableKey;
use App\Models\MedicalRecords;
use App\Models\RecordImage;
use App\Models\Tags;
use JD\Cloudder\Facades\Cloudder;

use App\Http\Requests;
use App\Http\Controllers\ActivityLogController;
use Session;

class MedicalRecordsController extends Controller
{

	protected function getToken()
	{
		return hash_hmac('sha256', str_random(40), config('app.key'));
	}

	public function getKey($algo = 'sha256', $length = 1024){
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

	public function index()
	{
		$records = MedicalRecords::where('patient_id',Auth::user()->id)->orderBy('created_at', 'DESC')->get();

		return view('patients.records')->with([
			'records' => $records,
		]);
	}

	public function saveRecord(Request $request)
	{
		$dta = $request->all();

		$preview = '';
		$record = new MedicalRecords();
		$record->patient_id = Auth::user()->id;
		$record->title = htmlentities($dta['title']);
		$record->content = htmlentities($dta['content']);
		$record->save();

		if(isset($dta['files']) && count($dta['files']) >= 1){
			foreach ($dta['files'] as $file) {
				if($file != null){
					Cloudder::upload($file, $this->getToken(), array("sign_url" => true));

					$img = new RecordImage();
					$img->record_id = $record->id;
					$img->img_url = Cloudder::getResult()['secure_url'];
					$img->created_at = Carbon::now();
					$img->save();

					$update = MedicalRecords::find($record->id);
					$update->img_url = Cloudder::getResult()['secure_url'];
					$update->save();
				}else{
					$update = MedicalRecords::find($record->id);
					$update->img_url = env('APP_URL').'img/no_image.jpeg';
					$update->save();
				}
			}
		}else{
			$update = MedicalRecords::find($record->id);
			$update->img_url = env('APP_URL').'img/no_image.jpeg';
			$update->save();
		}

		if(isset($dta['tags']) && count($dta['tags']) > 0){
			foreach ($dta['tags'] as $tag) {
				$tags = new Tags();
				$tags->record_id = $record->id;
				$tags->patient_id = Auth::user()->id;
				$tags->name = htmlentities(strtolower($tag));
				$tags->created_at = Carbon::now();
				$tags->save();
			}
		}

		$message = "You added a new health record in your vault entitled ".$dta['title'];
		ActivityLogController::saveLog(Auth::user()->id,$message);

		return redirect()->back()->with('success', 'New record was added to your vault.');

	}

	public function getRecord($id='')
	{

		$record = MedicalRecords::with('imgs')->find($id);

		if(Auth::check()){
			if(isset($record) && $record->patient_id == Auth::user()->id){
				return view('patients.record_data')->with('record', $record);
			}elseif(isset($record)){
				$user = Patient::find($record->patient_id);

				if($user->isFriendWith(Auth::user())){
					return view('patients.record_data')->with(['record'=> $record, 'readonly' => '1', 'in_circle' => 'You are currently viewing one of'. $user->profile->first_name . ' ' . $user->profile->last_name . '\'s health records']);
				}
			}else{
				return view('patients.record_data')->with('error', 'You don\'t have the permission to view this page.');
			}
		}
	}

	public function getRecordByDoctor($id='')
	{
		$record = MedicalRecords::with('imgs')->find($id);
		if(Auth::guard('doctor')->check() && isset($record)){
			if(Session::has('key')){
				$user = Patient::find($record->patient_id);
				return view('patients.record_data')->with(['record'=> $record, 'readonly' => '1', 'in_circle' => 'You are currently viewing one of'. $user->profile->first_name . ' ' . $user->profile->last_name . '\'s health records']);
			}else{
				return redirect('doctor/dashboard');
			}
			
		}else{
			return redirect('doctor/dashboard');
		}
	}

	public function getData($id)
	{
		$record = MedicalRecords::with('imgs')->find($id);

		if($record){
			return Response::json(['key' => $this->getKey(), 'record' => $record]);
		}
	}

	public function editRecord(Request $request)
	{
		$dta = $request->all();

		$record = MedicalRecords::with('imgs')->find($dta['id']);
		$record->title = $dta['title'];
		$record->content = $dta['content'];
		$record->save();

		return redirect()->back()->with('success', 'Changes to records has been saved.');

	}	

	public function removeAttachment($id)
	{
		$record = RecordImage::findOrFail($id);

		if($record){
			$record->delete();

			return redirect()->back()->with('success', 'Attachment has been removed.');
		}
	}

	public function addAttachment(Request $request)
	{
		$dta = $request->all();
		if(isset($dta['files']) && count($dta['files']) >= 1){
			$record = MedicalRecords::find($dta['id']);
			foreach ($dta['files'] as $file) {
				if($file != null){
					Cloudder::upload($file, $this->getToken(), array("sign_url" => true));

					$img = new RecordImage();
					$img->record_id = $record->id;
					$img->img_url = Cloudder::getResult()['secure_url'];
					$img->created_at = Carbon::now();
					$img->save();
				}else{
					$update = MedicalRecords::find($record->id);
					$update->img_url = env('APP_URL').'img/no_image.jpeg';
					$update->save();
				}
			}

			return redirect()->back()->with('success', 'Attachment has been added to your records.');

		}
	}
}
