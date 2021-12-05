<?php

namespace Database\Seeders;

use App\Models\Sys\Module;
use Illuminate\Database\Seeder;

class MenuSettingSeeder  extends Seeder
{
    public function run()
    {
        $parent = Module::create([
            'label' => 'Settings',
            'name' => 'settings',
            'route' => 'settings',
            'is_header' => true,
            'order' => 4,
            'icon' => 'GearIcon',
        ]);
        $parent->childrens()->createMany([
            [
                'label' => 'User',
                'name' => 'settings-users',
                'route' => 'settings-users',
                'is_header' => false,
                'order' => 1,
                'parent_id' => $parent->id,
                'icon' => 'UserIcon',
            ],
            [
                'label' => 'Role',
                'name' => 'settings-roles',
                'route' => 'settings-roles',
                'is_header' => false,
                'order' => 2,
                'parent_id' => $parent->id,
                'icon' => 'GitBranchIcon',
            ],
            [
                'label' => 'Menu',
                'name' => 'settings-menu',
                'route' => 'settings-menu',
                'is_header' => false,
                'order' => 3,
                'parent_id' => $parent->id,
                'icon' => 'GridIcon',
            ],
        ]);
    }

}
