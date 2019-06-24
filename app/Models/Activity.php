<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //config guards name
    protected $table = 'tbStu_Activity';

    public $timestamps = false;

    protected $guarded = [];
}