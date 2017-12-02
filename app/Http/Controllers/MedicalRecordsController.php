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

use HealthChain\Http\Requests;
use HealthChain\Http\Controllers\ActivityLogController;

class MedicalRecordsController extends Controller
{

	protected function getToken()
	{
		return hash_hmac('sha256', str_random(40), config('app.key'));
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

		// dd(count($dta['files']));
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

	// public function editRecord(Request $request)
	// {
	// 	$dta = $request->all();

	// 	// dd($request->file('files'));
	
	// 	$preview = '';
	// 	$record = Records::find($dta['id']);
	// 	$record->title = $dta['title'];
	// 	$record->content = $dta['content'];
	// 	$record->save();

	// 	foreach ($request->file('files') as $file) {
	// 	// dd($file);
	
	// 		Cloudder::upload($file, $this->getToken(), array("sign_url" => true));

	// 		$img = new RecordImages();
	// 		$img->record_id = $record->id;
	// 		$img->img_url = Cloudder::getResult()['secure_url'];
	// 		$img->created_at = Carbon::now();
	// 		$img->save();

	// 		$update = Records::find($record->id);
	// 		$update->img_url = Cloudder::getResult()['secure_url'];
	// 		$update->save();

	// 	}

	// 	$message = "You added a new health record in your vault entitled ".$dta['title'];
	// 	ActivityLogController::saveLog($user->id,$message);


	// 	return redirect()->back();

	// }

	public function getData($id)
	{
		$record = MedicalRecords::with('imgs')->find($id);

		if($record){
			return Response::json($record);
		}
	}

	public function editRecord(Request $request)
	{
		$dta = $request->all();

		$record = MedicalRecords::with('imgs')->find($dta['id']);
		$record->title = $dta['title'];
		$record->content = $dta['content'];
		$record->save();

		return Response::json($record);

	}	
}
