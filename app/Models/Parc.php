<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parc extends Model
{
    //config guards name
    protected $table = 'tbStu_parc';

    public $timestamps = false;

    protected $guarded = [];
}