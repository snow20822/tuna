<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    //config guards name
    protected $table = 'tbStu_Album';

    public $timestamps = false;

    protected $guarded = [];
}