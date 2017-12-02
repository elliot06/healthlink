<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecords extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'patient_id', 'title', 'content', 'img_url'
    ];

    public function patient()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id');
    }

    public function notifcations()
	{
		return $this->hasMany('App\Models\RecordImage','record_id','id');
    }
}
