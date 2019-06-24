<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //config guards name
    protected $table = 'tbStu_Service';

    public $timestamps = false;

    protected $guarded = [];
}