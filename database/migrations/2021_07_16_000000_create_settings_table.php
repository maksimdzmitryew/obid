<?php

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'psc';
    const TABLE_MIGRATION       = 'settings';

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
        $o_main->string('value')                                        ->nullable(false)               ->comment('value when it is locale independent');
        $o_main->boolean('is_translatable')                 ->default(0)->nullable(false)               ->comment('a flag for locale dependable value');
        $this->upMajorMigration($o_main);

        /**
         * table object with columns specific to this model's translations
         */
        $o_l10n = $this->getClassForCustomColumns();
        $o_l10n->string('name', 30)                         ->default('')->nullable(false)               ->comment('settings name for UI shown in various inputs‘ labels');
        $o_l10n->string('translated_value')                             ->nullable(false)               ->comment('value specific to each locale');
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
