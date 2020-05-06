<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('vocation_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('vocation_id');
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['vocation_id', 'locale', 'name']);
            $table->foreign('vocation_id')->references('id')->on('vocations')->onDelete('cascade');
        });

        Schema::create('artist_vocation', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('artist_id')->unsigned();
            $table->integer('vocation_id')->unsigned();
            $table->integer('order')->index()->default(0);

            $table->primary(['artist_id', 'vocation_id', 'order']);
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('vocation_id')->references('id')->on('vocations')->onDelete('cascade');
        });

        Schema::create('event_vocation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->integer('vocation_id')->unsigned();
            $table->integer('order')->index()->default(0);

            //$table->primary(['event_id', 'vocation_id', 'order']);
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('vocation_id')->references('id')->on('vocations')->onDelete('cascade');
        });

        Schema::create('artist_event_vocation', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('artist_id')->unsigned();
            $table->integer('event_vocation_id')->unsigned();
            $table->integer('order')->index()->default(0);

            $table->primary(['artist_id', 'event_vocation_id', 'order']);
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('event_vocation_id')->references('id')->on('event_vocation')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_event_vocation');
        Schema::dropIfExists('event_vocation');
        Schema::dropIfExists('artist_vocation');
        Schema::dropIfExists('vocation_translations');
        Schema::dropIfExists('vocations');
    }
}
