<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $super_admin = Role::create([
            'name' => 'superadmin',
            'display_name' => 'Superadmin',
            'guard_name' => 'api',

        ]);

        $admin = Role::create([
            'name' => 'administrator',
            'display_name' => 'Administrator',
            'guard_name' => 'api',
        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'guard_name' => 'api',
        ]);

    }
}
