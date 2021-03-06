<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionOrder extends Model
{
    protected $fillable = [
        'order_number',
        'order_date',
        'purchaser_id',
        'member_id',
        'rep_id',
        'email',
        'website',
        'phone',
        'fax',
        'shipping_from',
        'from_address',
        'from_city',
        'from_state',
        'from_zip',
        'from_email',
        'from_phone',
        'shipping_to',
        'to_address',
        'to_city',
        'to_state',
        'to_zip',
        'to_email',
        'to_phone',
    ];

    protected $guarded = [];

    public function proceeds()
    {
        return $this->hasMany('App\SubscriptionProceed','order_id','id')->get();
    }
}
