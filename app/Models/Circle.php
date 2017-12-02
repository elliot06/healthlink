<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circle extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'patient_id', 'total', 'amount'
    ];
}
