<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoalBooster extends Model
{
    protected $fillable = [
        'user','apparel','ultimate','scholarship','cash','ytd'
    ];

    protected $guarded = [];

}
