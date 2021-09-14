<?php

declare(strict_types=1);

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
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
        $o_main->char('iso', 2)                             ->default('')->nullable(false)->index()      ->comment('ISO 3166-1 alpha-2 country code');
        $this->upMajorMigration($o_main);

        /**
         * table object with columns specific to this model's translations
         */
        $o_l10n = $this->getClassForCustomColumns();
        $o_l10n->string('name', 30)                         ->default('')->nullable(false)               ->comment('country name for UI shown in various selectors and dropdowns');
        $this->upTranslationMigration($o_l10n);
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
