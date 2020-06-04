<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $fillable = [
        'user_id',
        'path',
        'type',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User','id','user_id');
    }
}
