<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOrderFestivalArtistTable extends Migration
{
    const TABLE_MIGRATION = 'festival_artist';
    const MIGRATION_KEY = 'order';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->smallInteger(self::MIGRATION_KEY)->unsigned()->default(9);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->dropColumn(self::MIGRATION_KEY);
        });
    }
}
