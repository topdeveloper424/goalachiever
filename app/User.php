<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','name','address1', 'email', 'password','role','phone','city','state','name2','address2','website','grade_type','educator','veteran','app_purchase','app_commission','representative','donation','amount','created_by','rep', 'avatar'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function files()
    {
        return $this->hasMany('App\UserFile','user_id','id');
    }

    public function GradeLevel()
    {
        return $this->hasOne('App\GradeLevel','id','grade_type');
    }
    public function TypeBusiness()
    {
        return $this->hasOne('App\TypeBusiness','id','grade_type');
    }

}
