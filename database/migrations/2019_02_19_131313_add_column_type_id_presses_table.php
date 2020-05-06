<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTypeIdPressesTable extends Migration
{
    const TABLE_MIGRATION = 'presses';
    const MIGRATION_OLD_FK = 'type';
    const TABLE_HASONE = 'categories';
    const TABLE_HASONE_FK = 'type_id';

    private function _getTypesIds() {
      return array (
          11 => 'review',
          23 => 'video',
          13 => 'photo',
      );
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->integer(self::TABLE_HASONE_FK.'_tmp')->unsigned()->nullable()->default(NULL)->after('festival_id');
            $table->integer(self::TABLE_HASONE_FK)->unsigned()->nullable()->default(NULL)->after('festival_id');
        });
        // default value for existing records
        $tmp = $this->_getTypesIds();
        foreach ($tmp as $key => $value) {
            DB::statement('UPDATE `' . self::TABLE_MIGRATION . '` SET `' . self::TABLE_HASONE_FK . '`' . " =  $key WHERE `" . self::MIGRATION_OLD_FK . "` = '$value' ;");
        }

        // copy default compatibility default values
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            DB::statement('UPDATE `' . self::TABLE_MIGRATION . '` SET `' . self::TABLE_HASONE_FK . '` = `' . self::TABLE_HASONE_FK . '_tmp`');
        });

        // remove column with default values
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->dropColumn(self::TABLE_HASONE_FK . '_tmp');
        });

        // remove old key column
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->dropColumn(self::MIGRATION_OLD_FK);
        });

        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->foreign(self::TABLE_HASONE_FK)->references('id')->on(self::TABLE_HASONE)->onDelete('cascade');
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
            $table->string(self::MIGRATION_OLD_FK)->nullable()->after('id')->index();
        });
        $tmp = $this->_getTypesIds();
        foreach ($tmp as $key => $value) {
            DB::statement('UPDATE `' . self::TABLE_MIGRATION . '` SET `' . self::MIGRATION_OLD_FK . '`' . " =  '$value' WHERE `" . self::TABLE_HASONE_FK . "` = '$key' ;");
        }
        Schema::table(self::TABLE_MIGRATION, function (Blueprint $table) {
            $table->dropForeign([self::TABLE_HASONE_FK]);
            $table->dropColumn(self::TABLE_HASONE_FK);
        });
    }
}
