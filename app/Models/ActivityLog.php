<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;
    
    public function patient()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
}
