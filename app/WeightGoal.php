<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightGoal extends Model
{
    protected $fillable = [
        'user','type','desire_lose','weight_start','current_weight','weight_lost','achieved','status','family','desire','health','other','start_date','goal_achieved','goal_achieved_time','cash_alert','cash_alert_time','credit_alert','credit_alert_time'
    ];

    protected $guarded = [];
}
