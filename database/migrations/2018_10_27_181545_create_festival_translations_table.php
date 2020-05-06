<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFestivalTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('festival_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('festival_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('slug')->index()->unique();
            $table->string('program_description')->nullable();
            $table->text('about_festival')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->unique(['festival_id', 'locale']);
            $table->foreign('festival_id')->references('id')->on('festivals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('festival_translations');
    }
}
