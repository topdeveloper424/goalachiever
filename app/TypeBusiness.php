<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeBusiness extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

    public $timestamps = false;
}
