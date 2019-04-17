<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('locksmith_id');
            $table->string('level');
            $table->string('make');
            $table->string('price');
            $table->text('card_num')->nullable();
            $table->text('serial_num')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('b_add')->nullable();
            $table->string('vin');
            $table->string('ls_id')->nullable();
            $table->string('password')->nullable();
            $table->string('status');
            $table->string('extra')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
