<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Introduction extends Model
{
	//改成跟mssql 一致
    const CREATED_AT = 'Createtime';
    const UPDATED_AT = 'Updatetime';

    //config guards name
    protected $table = 'tbStu_Introduction';

    protected $guarded = [];
}