<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormVideo extends Model
{
    protected $fillable = [
        'name','original_name','store_name','type','uploaded_by'
    ];

    protected $guarded = [];
}

/* type
0 : form
1 : video
2 : inspiring stories
3 : educator school talk
4 : veteran talk
5 : financial talk
6 : real talk
7 : entrepreneurs talk
*/