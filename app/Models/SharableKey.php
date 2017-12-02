<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharableKey extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'patient_id', 'recipient_name', 'recipient_mail', 'private_key', 'delete_on'
    ];
}
