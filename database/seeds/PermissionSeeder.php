<?php


use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::where('name', 'admin')->orWhere('name', 'user')->delete();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $admin = User::where(['email' => 'jonston85@gmail.com'])->first();

        $admin->assignRole('admin');
    }
}
