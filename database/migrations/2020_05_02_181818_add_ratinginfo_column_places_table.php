<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatinginfoColumnPlacesTable extends Migration
{
    const DB_CONNECTION = 'psc';
    const TABLE_MIGRATION = 'places';
    const COLUMN_AFTER = 'complaint_delay';
    const COLUMN_ADD = 'rating_info';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(self::DB_CONNECTION)->table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->longText(self::COLUMN_ADD)->nullable(FALSE)->default('')->after(self::COLUMN_AFTER)->comment('summary of rating for each element');
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
