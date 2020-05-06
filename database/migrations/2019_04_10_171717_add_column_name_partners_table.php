<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNamePartnersTable extends Migration
{
    const TABLE_MIGRATION = 'partners';
    const MIGRATION_KEY = 'title';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->string(self::MIGRATION_KEY)->default('')->after('id');
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