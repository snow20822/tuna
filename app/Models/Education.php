<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    //config guards name
    protected $table = 'tbStu_Education';

    public $timestamps = false;

    protected $guarded = [];
}