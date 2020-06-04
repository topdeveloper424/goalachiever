<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BbbProceed extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',

    ];

    protected $guarded = [];

    public $timestamps = false;

}
