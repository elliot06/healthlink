<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientAddress extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'patient_id', 'perma_address', 'perma_city', 'perma_province', 'perma_region', 'perma_postal',
        'pres_address', 'pres_city', 'pres_province', 'pres_region', 'pres_postal'
    ];

    public function patient()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
}
