<?php

declare(strict_types=1);

namespace Database\Seeders;

#use Spatie\Permission\Models\Role;
use App\Role;

use                         Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run() : void
    {
        $a_roles = ['admin', 'user', ];
dump('RoleSeeder');
        #Role::whereIn('name', $a_roles)->delete();

        for ($i = 0; $i < count($a_roles); $i++)
        {
            Role::create(['name' => $a_roles[$i]]);
        }
    }
}
