<?php

declare(strict_types=1);

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreateTextsTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'psc';
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        /**
         * columns specific to the core of the model
         */
        $o_main = $this->getClassForCustomColumns();
        $o_main->string('slug',60)              ->unique()  ->default('')->nullable(false)->index()     ->comment('code name to be used in views');
        $this->upMajorMigration($o_main);

        /**
         * table object with columns specific to this model's translations
         */
        $o_l10n = $this->getClassForCustomColumns();
        $o_l10n->string('name', 30)                         ->default('')->nullable(false)              ->comment('human readable title to distinguish between items in the list');
#        $table->text('description')                                             ->nullable(false);
        $o_l10n->text('body')                                           ->nullable(false)               ->comment('actual contents');
        $this->upTranslationMigration($o_l10n);

/*
        DB::connection($this->getConnection())->table($this->getTable())->insert(
            array(
                'id'            => 1,
                'published'     => 1,
                'slug'      => 'footer_contacts',
                'created_at'    => '2019-03-02 21:21:21',
                'updated_at'    => '2019-03-02 21:21:21',
            )
        );
        DB::connection($this->getConnection())->table($this->getTable())->insert(
            array(
                'id'            => 2,
                'published'     => 1,
                'slug'      => 'footer_about',
                'created_at'    => '2019-03-03 17:17:17',
                'updated_at'    => '2019-03-03 17:17:17',
            )
        );

        DB::connection($this->getConnection())->table($this->getTransTableName())->insert(
            array(
                'id'            => 1,
                'text_id'       => 1,
                'locale'        => 'uk',
                'name'          => 'Footer contacts',
                'body'   => '<p>T <a href="tel:+41 (0) 61 263 35 35">+41 (0) 61 263 35 35</a></p><p><a href="mailto:info@culturescapes.ch">info@culturescapes.ch</a></p><p>Schwarzwaldallee 200</p><p>CH-4058, Basel, Switzerland</p>',
            )
        );
        DB::connection($this->getConnection())->table($this->getTransTableName())->insert(
            array(
                'id'            => 2,
                'text_id'       => 2,
                'locale'        => 'uk',
                'name'          => 'Footer about',
                'body'   => 'CULTURESCAPES is a Swiss multidisciplinary festival committed to the promotion of cross-cultural dialogue, cooperation, and networking.',
            )
        );
*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->downTranslationMigration();
        $this->downMajorMigration();
    }
}
