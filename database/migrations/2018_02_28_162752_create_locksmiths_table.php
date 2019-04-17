<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocksmithsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locksmiths', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('company_add')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_status')->nullable();
            $table->string('status');
            $table->integer('package');
            $table->string('ls_id')->nullable();
            $table->string('password')->nullable();
            $table->string('preference')->nullable();
            $table->string('vcode');
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
        Schema::dropIfExists('locksmiths');
    }
}
