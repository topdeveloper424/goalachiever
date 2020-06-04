<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MortgageGoal extends Model
{
    protected $fillable = [
        'user',
        'type',
        'est_appraised_value',
        'down_payment_percent',
        'down_payment',
        'loan_amount',
        'purpose',
        'goal_achieved',
        'goal_achieved_time',
        'cash_alert',
        'cash_alert_time',
        'credit_alert',
        'credit_alert_time'
    ];

    protected $guarded = [];

}
