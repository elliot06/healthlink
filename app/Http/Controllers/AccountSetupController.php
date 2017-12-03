<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Response;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\PatientProfile;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\Notifcation;
use App\Models\Circle;

class AccountSetupController extends Controller
{

	public function index()
	{
		if(Auth::check()){
			return view('patients.setup');
		}else{
			return view('responses.account_confirmed')->with('error', 'error');
		}
	}

	public function checkFullName(Request $request)
	{
		$dta = $request->all();

		$exist = PatientName::where('last_name', $dta['lname'])->where('first_name', $dta['fname'])->where('middle_name', $dta['mname'])->where('extension_name', $dta['extname'])->first();

		if($exist){
			return 'exist';
		}else{
			return 'available';
		}
	}

	public function addFamily($l, $f, $m, $c, $cn, $e, $o, $r)
	{
		$family = new PatientFamily();
		$family->patient_id = Auth::user()->id;
		$family->first_name = htmlentities($f);
		$family->last_name = htmlentities($l);
		$family->middle_name = htmlentities($m);
		$family->citizenship = htmlentities($c);
		$family->contact = htmlentities($cn);
		$family->email = htmlentities($e);
		$family->occupation = htmlentities($o);
		$family->relationship = htmlentities($r);
		$family->created_at = Carbon::now();
		$family->save();

	}

	public function saveDetails(Request $request)
	{
		$dta = $request->all();

		$profile = new PatientProfile();
		$profile->patient_id = Auth::user()->id;
		$profile->last_name = htmlentities($dta['last_name']);
		$profile->first_name = htmlentities($dta['first_name']);
		$profile->middle_name = htmlentities($dta['middle_name']);
		$profile->home_contact = htmlentities($dta['home_contact']);
		$profile->cell_contact = htmlentities($dta['cell_contact']);
		$profile->gender = htmlentities($dta['gender']);
		$profile->age = htmlentities($dta['age']);
		$profile->birthdate = htmlentities($dta['birthdate']);
		$profile->birth_place = htmlentities($dta['birth_place']);
		$profile->citizenship = htmlentities($dta['citizenship']);
		$profile->height = htmlentities($dta['height']);
		$profile->weight = htmlentities($dta['weight']);
		$profile->bmi = htmlentities($dta['bmi']);
		$profile->bmi_category = htmlentities($dta['bmi_category']);
		$profile->blood_type = htmlentities($dta['blood_type']);
		$profile->created_at = Carbon::now();

		$address = new PatientAddress();
		$address->patient_id = Auth::user()->id;
		$address->perma_address = htmlentities($dta['perma_address']);
		$address->perma_city = htmlentities($dta['perma_city']);
		$address->perma_province = htmlentities($dta['perma_province']);
		$address->perma_region = htmlentities($dta['perma_region']);
		$address->perma_postal = htmlentities($dta['perma_postal']);

		if(isset($dta['same'])){
			$address->pres_address = htmlentities($dta['perma_address']);
			$address->pres_city = htmlentities($dta['perma_city']);
			$address->pres_province = htmlentities($dta['perma_province']);
			$address->pres_region = htmlentities($dta['perma_region']);
			$address->pres_postal = htmlentities($dta['perma_postal']);
		}else{
			$address->pres_address = htmlentities($dta['pres_address']);
			$address->pres_city = htmlentities($dta['pres_city']);
			$address->pres_province = htmlentities($dta['pres_province']);
			$address->pres_region = htmlentities($dta['pres_region']);
			$address->pres_postal = htmlentities($dta['pres_postal']);
		}

		$address->created_at = Carbon::now();

		$this->addFamily(htmlentities($dta['m_lname']), htmlentities($dta['m_fname']), htmlentities($dta['m_mname']), htmlentities($dta['m_citizenship']), htmlentities($dta['m_contact']), htmlentities($dta['m_email']), htmlentities($dta['m_occupation']), 'mother');

		$this->addFamily(htmlentities($dta['f_lname']), htmlentities($dta['f_fname']), htmlentities($dta['f_mname']), htmlentities($dta['f_citizenship']), htmlentities($dta['f_contact']), htmlentities($dta['f_email']), htmlentities($dta['f_occupation']), 'father');

		$circle = new Circle();
		$circle->patient_id = Auth::user()->id;
		$circle->total = 3;
		$circle->amount = 0;
		$circle->created_at = Carbon::now();
		$circle->save();

		$profile->save();
		$address->save();


		return redirect('/patient/dashboard')->with('success', 'Account Details was successfully saved!');
	}

}
