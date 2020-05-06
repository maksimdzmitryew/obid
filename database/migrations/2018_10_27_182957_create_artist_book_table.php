<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_book', function (Blueprint $table) {
            $table->unsignedInteger('artist_id');
            $table->unsignedInteger('book_id');

            $table->primary(['artist_id', 'book_id']);
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_book');
    }
}
