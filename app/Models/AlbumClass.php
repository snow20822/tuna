<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumClass extends Model
{
    //config guards name
    protected $table = 'tbStu_Album_Class';

    public $timestamps = false;

    protected $guarded = [];
}