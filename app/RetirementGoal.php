<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetirementGoal extends Model
{
    protected $fillable = [
        'user',
        'type',
        'part1_cur_age',
        'part1_re_age',
        'part1_year_to_retire',
        'part1_desire_income',
        'part1_est_income',
        'part1_re_funds',
        'part1_contribution',
        'part1_est_retire',
        'part1_balance',
        'part1_reached',
        'part2_contributions',
        'part2_returns',
        'part2_years',
        'part2_est_funds',
        'part3_existing_amount',
        'part3_previous_amount',
        'part3_total',
        'part3_start_date',
        'goal_achieved',
        'goal_achieved_time',
        'cash_alert',
        'cash_alert_time',
        'credit_alert',
        'credit_alert_time'
    ];

    protected $guarded = [];
}
