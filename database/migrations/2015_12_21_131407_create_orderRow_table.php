<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_row', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('quantity',false,true);

            $table->foreign('order_id')->references('id')->on('order');
            $table->foreign('item_id')->references('id')->on('item');
            $table->unique(array('order_id','item_id'));

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
        Schema::drop('orderRow');
    }
}
