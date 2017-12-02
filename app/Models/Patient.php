<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract; 
use Tymon\JWTAuth\Contracts\JWTSubject;

class Patient extends Model implements AuthenticatableContract, CanResetPasswordContract, JWTSubject
{
    use Authenticatable;
    use CanResetPassword;
    use Friendable;
    use SoftDeletes;
    use Notifiable;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:50',
        'email' => 'required|string|email|max:255|unique:patients',
        'password' => 'required|string|min:6'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string'
    ];

    public function profile()
	{
		return $this->hasOne('App\Models\PatientProfile','patient_id','id');
    }
    
    public function address()
	{
		return $this->hasOne('App\Models\PatientAddress','patient_id','id');
    }
    
    public function family()
	{
		return $this->hasMany('App\Models\PatientFamily','patient_id','id');
    }
    
    public function records()
	{
		return $this->hasMany('App\Models\MedicalRecords','patient_id','id');
    }

    public function notifcations()
	{
		return $this->hasMany('App\Models\Notification','patient_id','id');
    }

    public function logs()
	{
		return $this->hasMany('App\Models\ActivityLog','patient_id','id');
    }
}
