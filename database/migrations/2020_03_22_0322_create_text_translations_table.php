<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreateTextTranslationsTable extends Migration
{
	const DB_CONNECTION		= 'psc';
    const TABLE_MIGRATION	= 'text_translations';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('text_id')	->unsigned()								->nullable(false);
            $table->char('locale',2)				->index()						->nullable(false);
            $table->string('name')													->nullable(false);
            $table->string('slug')					->unique();
            $table->text('description')												->nullable(false);
            $table->unique(['text_id', 'locale']);
            $table->foreign('text_id')->references('id')->on('texts')->onDelete('cascade');
        });
        DB::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 1,
                'text_id'       => 1,
                'locale'        => 'uk',
                'name'          => 'Footer contacts',
                'slug'          => 'footer-contacts',
                'description'   => '<p>T <a href="tel:+41 (0) 61 263 35 35">+41 (0) 61 263 35 35</a></p><p><a href="mailto:info@culturescapes.ch">info@culturescapes.ch</a></p><p>Schwarzwaldallee 200</p><p>CH-4058, Basel, Switzerland</p>',
            )
        );
        DB::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION)->insert(
            array(
                'id'            => 2,
                'text_id'       => 2,
                'locale'        => 'uk',
                'name'          => 'Footer about',
                'slug'          => 'footer-about',
                'description'   => 'CULTURESCAPES is a Swiss multidisciplinary festival committed to the promotion of cross-cultural dialogue, cooperation, and networking.',
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
        Schema::connection(self::DB_CONNECTION)->dropIfExists(self::TABLE_MIGRATION);
    }
}
