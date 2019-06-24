<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    //config guards name
    public $incrementing = true;
    protected $table = 'users';

    protected $fillable = [];
}