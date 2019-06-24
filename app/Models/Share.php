<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    //config guards name
    protected $table = 'tbStu_share';

    public $timestamps = false;

    protected $guarded = [];
}