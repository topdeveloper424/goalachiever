<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalGoal extends Model
{
    protected $fillable = [
        'user','type','time_frame','status','family','desire','health','other','start_date','goal_achieved','goal_achieved_time','cash_alert','cash_alert_time','credit_alert','credit_alert_time'
    ];

    protected $guarded = [];
}
