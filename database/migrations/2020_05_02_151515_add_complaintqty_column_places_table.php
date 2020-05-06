<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComplaintqtyColumnPlacesTable extends Migration
{
    const DB_CONNECTION = 'psc';
    const TABLE_MIGRATION = 'places';
    const COLUMN_AFTER = 'rating_min';
    const COLUMN_ADD = 'complaint_qty';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->smallInteger(self::COLUMN_ADD)->unsigned()->nullable(FALSE)->default(0)->after(self::COLUMN_AFTER)->index()->comment('number of open aka active complaints at the moment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->dropColumn(self::COLUMN_ADD);
        });
    }
}
