<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileWeb extends Model
{
    //config guards name
    protected $table = 'tbStu_URL';

    public $timestamps = false;

    protected $guarded = [];
}