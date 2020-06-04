<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'goal',
        'user',
        'type',
        'text',
        'age',
    ];

    protected $guarded = [];

}
