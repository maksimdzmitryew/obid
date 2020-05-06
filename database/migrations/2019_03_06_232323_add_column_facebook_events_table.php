<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFacebookEventsTable extends Migration
{
    const TABLE_MIGRATION = 'events';
    const MIGRATION_KEY = 'facebook';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->string(self::MIGRATION_KEY)->default('');
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
