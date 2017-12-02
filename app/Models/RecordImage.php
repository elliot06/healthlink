<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecordImage extends Model
{

    public $fillable = [
        'patient_id', 'record_id', 'img_url'

    ];

    public function patient()
	{
		return $this->belongsTo('App\Models\MedicalRecords', 'record_id');
    }
}
