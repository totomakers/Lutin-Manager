<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date');
            $table->string('name');
            $table->string('address');
            $table->integer('user_id')->unsigned();
            $table->integer('status');
            $table->datetime('date_validation');

            $table->foreign('user_id')->references('id')->on('user');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order');
    }
}
