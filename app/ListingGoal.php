<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingGoal extends Model
{
    protected $fillable = [
        'user',
        'type',
        'listing_price',
        'listing_credit',
        'goal_achieved',
        'goal_achieved_time',
        'cash_alert',
        'cash_alert_time',
        'credit_alert',
        'credit_alert_time'
    ];

    protected $guarded = [];

}
