<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCountryUsersTable extends Migration
{
    const TABLE_MIGRATION = 'users';
    const TABLE_HASONE = 'countries';
    const HASONE_TABLE = 'country';
    const HASONE_KEY = 'id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->integer(self::HASONE_TABLE.'_'.self::HASONE_KEY.'_tmp')->unsigned()->nullable()->default(246)->after('id');
            $table->integer(self::HASONE_TABLE.'_'.self::HASONE_KEY)->unsigned()->nullable()->default(NULL)->after('id');
        });

        // copy default compatibility default values
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            DB::statement('UPDATE `' . self::TABLE_MIGRATION . '` SET `' . self::HASONE_TABLE.'_'.self::HASONE_KEY . '` = `' . self::HASONE_TABLE.'_'.self::HASONE_KEY . '_tmp`');
        });

        // remove column with default values
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->dropColumn(self::HASONE_TABLE.'_'.self::HASONE_KEY . '_tmp');
        });

        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->foreign(self::HASONE_TABLE.'_'.self::HASONE_KEY)->references(self::HASONE_KEY)->on(self::TABLE_HASONE)->onDelete('cascade');
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
            $table->dropForeign([self::HASONE_TABLE.'_'.self::HASONE_KEY]);
            $table->dropColumn(self::HASONE_TABLE.'_'.self::HASONE_KEY);
        });
    }
}
