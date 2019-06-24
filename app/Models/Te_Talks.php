<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Te_Talks extends Model
{
    //config guards name
    protected $table = 'tbTe_Talks';

    public $timestamps = false;

    protected $guarded = [];
}