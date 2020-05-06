<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventHoldingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_holdings', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();;
            $table->integer('event_id')->unsigned();
            $table->integer('place_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('ticket_url')->nullable();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_holdings');
    }
}
