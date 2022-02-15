<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\User;
use Spatie\Permission\Models\Role;

use                         Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run() : void
    {
        $a_emails = ['admin@admin.com', ];
dump('UserSeeder');

        #User::whereIn('email', [$a_emails, ])->delete();

        factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ]);
    }
}
