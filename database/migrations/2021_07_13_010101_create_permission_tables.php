<?php

use           Illuminate\Database\Schema\Blueprint;
use           Illuminate\Support\Facades\Schema;
use       Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
	const DB_CONNECTION		= 'psc';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$tableNames = config('permission.table_names');
		$columnNames = config('permission.column_names');
		$a_per_roles = [$tableNames['permissions'] => 'machine name in latin alphabet to compare if action is allowed for users who have this permission as part of their role', $tableNames['roles'] => 'human name for role',];
		foreach ($a_per_roles AS $s_table_name => $s_comment)
		{
			Schema::create($s_table_name, function (Blueprint $table) use ($s_comment) {
				$table->increments('id');
				$table->string('name')->comment($s_comment);
				$table->string('guard_name')														->nullable(false)->index()->comment('which communication way is used to access the resource');
				$table->timestamps();
			});
		}

		Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames)
			{
				$table->unsignedInteger('permission_id')								->nullable(false)->comment('combination of function name and guard');
				$table->string('model_type')														->nullable(false)->comment('model namespace full name');
				$table->unsignedBigInteger($columnNames['model_morph_key'])->nullable(false)->comment('record id in the modelʼs table');
				$table->index([$columnNames['model_morph_key'], 'model_type', ]);

				$table->foreign('permission_id')
					->references('id')
					->on($tableNames['permissions'])
					->onDelete('cascade');

				$table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
						'model_has_permissions_permission_model_type_primary');
			});

		Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames)
			{
				$table->unsignedInteger('role_id')											->nullable(false)->comment('combination of human readable role name and guard');
				$table->string('model_type')														->nullable(false)->comment('model namespace full name');
				$table->unsignedBigInteger($columnNames['model_morph_key'])->nullable(false)->comment('record id in the modelʼs table');
				$table->index([$columnNames['model_morph_key'], 'model_type', ]);

				$table->foreign('role_id')
					->references('id')
					->on($tableNames['roles'])
					->onDelete('cascade');

				$table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
						'model_has_roles_role_model_type_primary');
			});

		Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
			$table->unsignedInteger('permission_id');
			$table->unsignedInteger('role_id');

			$table->foreign('permission_id')
				->references('id')
				->on($tableNames['permissions'])
				->onDelete('cascade');

			$table->foreign('role_id')
				->references('id')
				->on($tableNames['roles'])
				->onDelete('cascade');

			$table->primary(['permission_id', 'role_id']);

			app('cache')->forget('spatie.permission.cache');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$tableNames = config('permission.table_names');

		Schema::drop($tableNames['role_has_permissions']);
		Schema::drop($tableNames['model_has_roles']);
		Schema::drop($tableNames['model_has_permissions']);
		Schema::drop($tableNames['roles']);
		Schema::drop($tableNames['permissions']);
	}
}