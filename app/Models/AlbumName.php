<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumName extends Model
{
    //config guards name
    protected $table = 'tbStu_Album_Name';

    public $timestamps = false;

    protected $guarded = [];
}