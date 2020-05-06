<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDurationColumnEventtranslationsTable extends Migration
{
    const TABLE_MIGRATION = 'event_translations';
    const MIGRATION_KEY = 'duration';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            if(Schema::hasColumn(self::TABLE_MIGRATION, self::MIGRATION_KEY))
                $table->dropColumn(self::MIGRATION_KEY);
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
            $table->string(self::MIGRATION_KEY)->default('-')->after('title');
        });
    }
}
