<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoalType extends Model
{
    protected $fillable = [
        'goal','name'
    ];

    protected $guarded = [];

    public $timestamps = false;
}
