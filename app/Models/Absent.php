<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    //config guards name
    protected $table = 'tbStu_Absent';

    public $timestamps = false;

    protected $guarded = [];
}