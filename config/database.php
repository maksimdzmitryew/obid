<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work. Of course
	| you may use many connections at once using the Database library.
	|
	*/

	'default' => env('DB_CONNECTION', 'mysql'),

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => [

		'sqlite_unittest' => [
			'driver' => 'sqlite',
			'database' =>
				# relative to storage/ folder
				storage_path('database.sqlite'),
				#':memory:',
				#env('DB_DATABASE', storage_path('database.sqlite')),
				#env('DB_DATABASE', database_path('database.sqlite')),
			'prefix' => '',
		],

		'mysql' => [
			'driver'		=> env('DB_CONNECTION',			'mysql'),
			'host'			=> env('DB_HOST',				'127.0.0.1'),
			'port'			=> env('DB_PORT',				'3306'),
			'database'		=> env('DB_DATABASE',			'forge'),
			'username'		=> env('DB_USERNAME',			'forge'),
			'password'		=> env('DB_PASSWORD',			''),
			'unix_socket'	=> env('DB_SOCKET',				''),
			'charset'		=> 'utf8mb4',
			'collation'		=> 'utf8mb4_unicode_ci',
			'prefix'		=> '',
			'strict'		=> false,
			# DYNAMIC allows to store long key indexes.
			'engine'		=> 'InnoDB ROW_FORMAT=DYNAMIC',
		],

		# project specific connection
		'psc' => [
			'driver'		=> env('PSC_DB_CONNECTION',		'mysql'),
			'host'			=> env('PSC_DB_HOST',			'127.0.0.1'),
			'port'			=> env('PSC_DB_PORT',			'3306'),
			'database'		=> env('PSC_DB_DATABASE',		'forge'),
			'username'		=> env('PSC_DB_USERNAME',		'forge'),
			'password'		=> env('PSC_DB_PASSWORD',		''),
			'charset'		=> 'utf8',
			'prefix'		=> env('PSC_DB_PREFIX',			'psc').'_',
			'schema'		=> 'public',
			'charset'		=> 'utf8mb4',
			'collation'		=> 'utf8mb4_unicode_ci',
			'strict'		=> false,
			# DYNAMIC allows to store long key indexes.
			'engine'		=> 'InnoDB ROW_FORMAT=DYNAMIC',
		],

		# user storage uploads
		'usu' => [
			'driver'		=> env('USU_DB_CONNECTION',		'mysql'),
			'host'			=> env('USU_DB_HOST',			'127.0.0.1'),
			'port'			=> env('USU_DB_PORT',			'3306'),
			'database'		=> env('USU_DB_DATABASE',		'forge'),
			'username'		=> env('USU_DB_USERNAME',		'forge'),
			'password'		=> env('USU_DB_PASSWORD',		''),
			'charset'		=> 'utf8',
			'prefix'		=> env('USU_DB_PREFIX',			'usu').'_',
			'schema'		=> 'public',
			'charset'		=> 'utf8mb4',
			'collation'		=> 'utf8mb4_unicode_ci',
			'strict'		=> false,
			# DYNAMIC allows to store long key indexes.
			'engine'		=> 'InnoDB ROW_FORMAT=DYNAMIC',
		],

		'pgsql' => [
			'driver' => 'pgsql',
			'host' => env('DB_HOST', '127.0.0.1'),
			'port' => env('DB_PORT', '5432'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset' => 'utf8',
			'prefix' => '',
			'schema' => 'public',
			'sslmode' => 'prefer',
		],

		'sqlsrv' => [
			'driver' => 'sqlsrv',
			'host' => env('DB_HOST', 'localhost'),
			'port' => env('DB_PORT', '1433'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset' => 'utf8',
			'prefix' => '',
		],

	],

	/*
	|--------------------------------------------------------------------------
	| Migration Repository Table
	|--------------------------------------------------------------------------
	|
	| This table keeps track of all the migrations that have already run for
	| your application. Using this information, we can determine which of
	| the migrations on disk haven't actually been run in the database.
	|
	*/

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => [

		'client' => 'predis',

		'default' => [
			'host' => env('REDIS_HOST', '127.0.0.1'),
			'password' => env('REDIS_PASSWORD', null),
			'port' => env('REDIS_PORT', 6379),
			'database' => 0,
		],

	],

];
