<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public $hidden = ['id'];
}
