<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientFamily extends Model
{
    protected $dates = ['deleted_at'];

    public $fillable = [
        'patient_id', 'first_name', 'middle_name', 'last_name', 'contact', 'citizenship',
        'email', 'occupation', 'relationship'
    ];

    public function patient()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
}
