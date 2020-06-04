<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contributon extends Model
{
    protected $fillable = [
        'goal','goal_id','type','date','price'
    ];

    protected $guarded = [];

    public $timestamps = false;
}
