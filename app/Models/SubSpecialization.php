<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSpecialization extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'title', 'description'
    ];
}
