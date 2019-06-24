<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInitUserLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            'username' => 'student',
            'password' => '$2y$10$94J8C7uMkkAxUcwNZLTsju6Yyt.bWNUcdu1ko/UFDA4IOajbDNTsa',
            'type' => 'student',
        ]);
        DB::table('users')->insert([
            'username' => 'teacher',
            'password' => '$2y$10$DDt9r7DuQFQezBVV1w43Q.4bc0Yzi4tS81H10xGIVs.kH1SfRKgKW',
            'type' => 'teacher',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
