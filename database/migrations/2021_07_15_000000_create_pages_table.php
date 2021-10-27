<?php

declare(strict_types=1);

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'psc';
    const TABLE_MIGRATION       = 'pages';

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
        $this->addForeignKey($this, $o_main, NULL, 'parent for pages at sub-levels');
        $o_main->string('slug')                 ->unique()  ->default('')->nullable(false)->index()     ->comment('url compatible page name');
        $o_main->smallInteger('order')->unsigned()          ->default(1)->nullable(false)->index()      ->comment('sorting position');
        $this->upMajorMigration($o_main);

        /**
         * table object with columns specific to this model's translations
         */
        $o_l10n = $this->getClassForCustomColumns();
        $o_l10n->string('title', 300)                       ->default('')->nullable(false)               ->comment('page name for UI');
        $o_l10n->text('excerpt')                            ->default('')->nullable(false)              ->comment('annotation of page contents');
        $o_l10n->text('body')                                           ->nullable()                    ->comment('page contents');
        $o_l10n->string('meta_title')                                   ->nullable()                    ->comment('meta tag for page title');
        $o_l10n->string('meta_keywords', 1000)                          ->nullable()                    ->comment('meta tag for manually listing of key concepts described in the page');
        $o_l10n->string('meta_description', 1000)                       ->nullable()                    ->comment('meta tag for page excerpt');
        $this->upTranslationMigration($o_l10n);

        $this->runSeedTable();
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
