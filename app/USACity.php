<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USACity extends Model
{
    protected $fillable = [
        'city',
        'state_code',
    ];

    protected $guarded = [];
}
