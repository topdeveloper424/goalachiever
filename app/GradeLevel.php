<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

    public $timestamps = false;
}
