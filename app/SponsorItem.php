<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponsorItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'plan_type',
        'purchase_price',
        'purchased_credits',
        'net_profit',
        'purchased_type',
        'qty_purchased',
        'total_purchased_credits',
        'total_net_profit',
        'total_qty_purchased',
        'member',
        'ur_25k',
        'ur_monthly',
        'ur_sponsor',
        'ur_participant',
        'achiever_alerts',
        'admin',
        'scholarship',
        'school_donations',
        'charity',
        'rep',
        'goal_achiever',
    ];

    protected $guarded = [];
}
