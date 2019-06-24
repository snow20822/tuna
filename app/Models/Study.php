<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    //config guards name
    protected $table = 'tbStu_study';

    public $timestamps = false;

    protected $guarded = [];
}