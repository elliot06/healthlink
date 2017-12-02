<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'patient_id', 'content', 'is_notified'
    ];

    public function patient()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
}
