<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    //config guards name
    protected $table = 'tbStu_Show';

    public $timestamps = false;

    protected $guarded = [];
}