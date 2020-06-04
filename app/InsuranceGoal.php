<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceGoal extends Model
{
    protected $fillable = [
        'user',
        'type',
        'annual_income',
        'est_coverage',
        'part2_contributions',
        'part2_returns',
        'part2_years',
        'part2_est_funds',
        'goal_achieved',
        'goal_achieved_time',
        'cash_alert',
        'cash_alert_time',
        'credit_alert',
        'credit_alert_time'
    ];

    protected $guarded = [];
}
