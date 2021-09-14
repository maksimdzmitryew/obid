<?php

declare(strict_types=1);

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'usu';

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        $a_options = [];
        $a_options['id'] = 'big';
        $a_options['published'] = 1;

        /**
         * columns specific to the core of the model
         */
        $o_main = $this->getClassForCustomColumns();

        $o_main->integer('fileable_id')         ->unique()              ->nullable()    ->index()       ->comment('morphed Model‘s record id');
        $o_main->string('fileable_type')        ->unique()  ->default('')->nullable(false)->index()     ->comment('morphed Model with namespace');

        $o_main->tinyInteger('position') ->unsigned()       ->default(0)->nullable(false)               ->comment('when manual sorting is applied; default is by time uploaded');
        $o_main->integer('size')         ->unsigned()       ->default(0)->nullable(false)               ->comment('in bytes');
        $o_main->string('type')                             ->default('')->nullable(false)->index()     ->comment('as ‘type‘ from ‘mime-type‘; don‘t mix with extention');
        $o_main->string('title')                            ->default('')->nullable(false)              ->comment('original file name as it was at computer uploaded from');
        $o_main->char('savedname',44)                       ->default('')->nullable(false)->index()     ->comment('obfuscated file name on server incl. extension');
        $o_main->char('url',60)                             ->default('')->nullable(false)              ->comment('path used in web-page to show file');
        $o_main->string('url_medium')                       ->default('')->nullable(false)              ->comment('images only, url used in web-page to show file');
        $o_main->string('url_small')                        ->default('')->nullable(false)              ->comment('images only, url used in web-page to show file');
        $o_main->char('path',58)                            ->default('')->nullable(false)              ->comment('complete path to file on server disk');
        $o_main->string('path_medium')                      ->default('')->nullable(false)              ->comment('images only, path on server disk to file');
        $o_main->string('path_small')                       ->default('')->nullable(false)              ->comment('images only, path on server disk to file');

        $this->upMajorMigration($o_main, $a_options);

        /**
         * table object with columns specific to this model's translations
         */
        $o_l10n = $this->getClassForCustomColumns();

        $o_l10n->string('name')                             ->default('')->nullable(false)              ->comment('name for UI shown to visitors');
        $o_l10n->string('copyright')                        ->default('')->nullable(false)              ->comment('copyright owner');
        $o_l10n->string('alt')                              ->default('')->nullable(false)              ->comment('description shown in a tooltip or when image is missing in a page');

        $this->upTranslationMigration($o_l10n, $a_options);
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
