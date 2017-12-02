<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\ActivityLog;
use App\Models\Patient;
use Carbon\Carbon;
use Auth;

class ActivityLogController extends Controller
{

	public static function saveLog($id, $content)
	{
		$log = new ActivityLog();
		$log->patient_id = $id;
		$log->content = $content;
		$log->created_at = Carbon::now();
		$log->save();
	}

	public function getLogs(Request $request)
	{
		if(Auth::check()){
			$user = Auth::user();
		}else{
			$user = Patient::find($request['id']);
		}

		$logs = ActivityLog::where('patient_id', $user->id)->get();

		return Response::json($logs);
	}
}
