<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
    //config guards name
    protected $table = 'tbStu_Read';

    public $timestamps = false;

    protected $guarded = [];
}