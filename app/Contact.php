<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name','phone','website','email','contact_name','address','type'
    ];

    protected $guarded = [];

    public $timestamps = false;
}
