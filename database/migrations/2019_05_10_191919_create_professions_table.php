<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionsTable extends Migration
{
    const TABLE_MIGRATION = 'professions';
    const TABLE_SUPPORTING = 'profession';
    const TABLE_XTRA = 'festival_artist';
    const MIGRATION_KEY = 'id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->increments(self::MIGRATION_KEY);
            $table->timestamps();
        });
        Schema::create(self::TABLE_SUPPORTING . '_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger(self::TABLE_SUPPORTING . '_' . self::MIGRATION_KEY);
            $table->string('locale')->index();
            $table->string('name');

            $table
                ->unique([self::TABLE_SUPPORTING . '_' . self::MIGRATION_KEY, 'locale', 'name']);
            $table
                ->foreign(self::TABLE_SUPPORTING . '_' . self::MIGRATION_KEY)
                ->references(self::MIGRATION_KEY)
                ->on(self::TABLE_MIGRATION)
                ->onDelete('cascade');
        });
        Schema::table(self::TABLE_XTRA, function (Blueprint $table) {
            $table->integer(self::TABLE_SUPPORTING . '_' . self::MIGRATION_KEY)->unsigned()->nullable()->default(NULL)->after('festival_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_XTRA, function (Blueprint $table) {
            $table->dropColumn(self::TABLE_SUPPORTING . '_' . self::MIGRATION_KEY);
        });
        Schema::dropIfExists(self::TABLE_SUPPORTING . '_translations');
        Schema::dropIfExists(self::TABLE_MIGRATION);
    }
}