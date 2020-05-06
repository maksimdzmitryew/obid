<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatingallColumnPlacesTable extends Migration
{
    const DB_CONNECTION = 'psc';
    const TABLE_MIGRATION = 'places';
    const COLUMN_AFTER = 'lng';
    const COLUMN_ADD = 'rating_all';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->smallInteger(self::COLUMN_ADD)->nullable(FALSE)->default(-1)->after(self::COLUMN_AFTER)->index()->comment('total rating percentage for the place');
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
