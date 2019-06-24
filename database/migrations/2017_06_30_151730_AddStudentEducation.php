<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentEducation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentEducation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order')->nullable();
            $table->string('school', '200')->nullable();
            $table->string('department', '200')->nullable();
            $table->string('year', '100')->nullable();
            $table->string('month', '50')->nullable();
            $table->string('status', '200')->nullable();
            $table->index('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studentEducation');
    }
}
