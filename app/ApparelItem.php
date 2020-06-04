<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApparelItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'ur_type',
        'unit_price',
        'cost',
        'net_profit',
        'profit_margin',
        'quantity_sold',
        'total_net_profit',
        'quantity_in_stock',
        'inventory',
        'total_cost',
        'shipping_cost',
        'weight',
        'back_order',
        'vendor',

        'ur_credits',
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
        'size_name',
        'size_1s',
        'size_xs',
        'size_s',
        'size_m',
        'size_l',
        'size_xl',
        'size_xxl',
        'size_3xl',
        'size_4xl',
        'size_5xl',
    ];

    protected $guarded = [];

}
