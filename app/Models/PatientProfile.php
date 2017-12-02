<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{

    public $fillable = [
        'patient_id', 'first_name', 'middle_name', 'last_name', 'home_contact', 'cell_contact', 'gender',
        'age', 'birthdate', 'citizenship', 'height', 'weight', 'bmi', 'bmi_category', 'blood_type',
        'deceased', 'death_date', 'cause_of_death'

    ];

    public function patient()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
}
