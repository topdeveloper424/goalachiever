<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialGoal extends Model
{
    protected $fillable = [
        'user','type','cost','time_frame','saving_goals','contribution','balance','reached','start_date','goal_achieved','goal_achieved_time','cash_alert','cash_alert_time','credit_alert','credit_alert_time'
    ];

    protected $guarded = [];


}
