<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextTranslationsTable extends Migration
{
    const TABLE_MIGRATION = 'text_translations';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('text_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();

            $table->unique(['text_id', 'locale']);
            $table->foreign('text_id')->references('id')->on('texts')->onDelete('cascade');
        });
        DB::table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 1,
                'text_id'       => 1,
                'locale'        => 'en',
                'name'          => 'Footer contacts',
                'slug'          => 'footer-contacts',
                'description'   => '<p>T <a href="tel:+41 (0) 61 263 35 35">+41 (0) 61 263 35 35</a></p><p><a href="mailto:info@culturescapes.ch">info@culturescapes.ch</a></p><p>Schwarzwaldallee 200</p><p>CH-4058, Basel, Switzerland</p>',
            )
        );        
        DB::table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 2,
                'text_id'       => 1,
                'locale'        => 'de',
                'name'          => 'Kontakte in der Fußzeile',
                'slug'          => 'kontakte-in-der-fusszeile',
                'description'   => '<p>T <a href="tel:+41 (0) 61 263 35 35">+41 (0) 61 263 35 35</a></p><p><a href="mailto:info@culturescapes.ch">info@culturescapes.ch</a></p><p>de Schwarzwaldallee 200</p><p>de CH-4058, Basel, Schweiz</p>',
            )
        );        
        DB::table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 3,
                'text_id'       => 2,
                'locale'        => 'en',
                'name'          => 'Footer about',
                'slug'          => 'footer-about',
                'description'   => 'CULTURESCAPES is a Swiss multidisciplinary festival committed to the promotion of cross-cultural dialogue, cooperation, and networking.',
            )
        );        
        DB::table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 4,
                'text_id'       => 2,
                'locale'        => 'de',
                'name'          => 'Fußzeile ungefähr',
                'slug'          => 'fusszeile-ungefahr',
                'description'   => 'CULTURESCAPES ist ein multidisziplinäres Schweizer Festival zur Förderung von interkultureller Zusammenarbeit und Vernetzung.',
            )
        );        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_MIGRATION);
    }
}
