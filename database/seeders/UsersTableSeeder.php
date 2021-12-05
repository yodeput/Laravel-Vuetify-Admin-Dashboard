<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\Module;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $userSuper= User::create([
            'username' => 'superadmin',
            'name' => 'Superadmin',
            'email' => 'super@admin.com',
            'password' => bcrypt('pass@word1'),
            'email_verified_at' => now()

        ]);
        $roleSuper = Role::query()->where('name','superadmin')->first();
        $userSuper->assignRole($roleSuper);
        $userSuper->save();
        $roleSuper->givePermissionTo(Permission::all());

        $userAdmin = User::create([
            'username' => 'administrator',
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('pass@word1'),
            'email_verified_at' => now()

        ]);
        $roleAdmin = Role::query()->where('name','administrator')->first();
        $userAdmin->assignRole($roleAdmin);
        $userAdmin->save();
        $permissionAdmin = Permission::query()->whereIn('display_name', ['read','create','update'])->get();
        $roleAdmin->givePermissionTo($permissionAdmin);
    }
}
