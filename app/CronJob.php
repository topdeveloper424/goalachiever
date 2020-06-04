<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    protected $fillable = [
        'user','goal','type','mode','month','week','day','last_time','active'
    ];

    protected $guarded = [];

    public $timestamps = false;

}
