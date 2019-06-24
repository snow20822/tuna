<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    //config guards name
    protected $table = 'tbStu_League';

    public $timestamps = false;

    protected $guarded = [];
}