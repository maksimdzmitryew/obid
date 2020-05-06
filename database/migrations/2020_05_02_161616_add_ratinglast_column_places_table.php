<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatinglastColumnPlacesTable extends Migration
{
    const DB_CONNECTION = 'psc';
    const TABLE_MIGRATION = 'places';
    const COLUMN_AFTER = 'complaint_qty';
    const COLUMN_ADD = 'rating_last';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->timestamp(self::COLUMN_ADD)->nullable(FALSE)->default('0000-00-00')->after(self::COLUMN_AFTER)->index()->comment('latest moment when the rating was re-calculated');
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
