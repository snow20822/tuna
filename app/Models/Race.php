<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    //config guards name
    protected $table = 'tbStu_Race';

    public $timestamps = false;

    protected $guarded = [];
}