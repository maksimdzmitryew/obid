<?php

use               Illuminate\Database\Schema\Blueprint;
use           Illuminate\Database\Migrations\Migration;
use                               App\Traits\MigrationTrait;
use               Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    use MigrationTrait;

    const DB_CONNECTION         = 'psc';

    protected static $o_country = '';

    public function __construct()
    {
        self::$o_country        = new CreateCountriesTable();
    }

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
        $this->addForeignKey(self::$o_country, $o_main);
        $o_main->string('timezone', 40)                   ->default('')->nullable(false)->index()      ->comment('PHP name for timezone, e.g. Europe/Zurich or Etc/GMT-13. See docs https://www.php.net/manual/en/timezones.php');
        $this->upMajorMigration($o_main);

        /**
         * table object with columns specific to this model's translations
         */
        $o_l10n = $this->getClassForCustomColumns();
        $o_l10n->string('name', 30)                       ->default('')->nullable(false)               ->comment('city name for UI shown in various selectors and dropdowns');
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
