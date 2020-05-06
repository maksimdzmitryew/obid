<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComplaintdelayColumnPlacesTable extends Migration
{
    const DB_CONNECTION = 'psc';
    const TABLE_MIGRATION = 'places';
    const COLUMN_AFTER = 'rating_last';
    const COLUMN_ADD = 'complaint_delay';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->timestamp(self::COLUMN_ADD)->nullable(FALSE)->default('0000-00-00')->after(self::COLUMN_AFTER)->index()->comment('moratorium date for delaying sending out new complaints');
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
