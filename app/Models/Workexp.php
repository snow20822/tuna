<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workexp extends Model
{
    //config guards name
    protected $table = 'tbStu_Workexp';

    public $timestamps = false;

    protected $guarded = [];
}