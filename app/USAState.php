<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USAState extends Model
{
    protected $fillable = [
        'state',
        'state_code',
    ];

    protected $guarded = [];

}
