<?php

namespace Database\Seeders;

use App\Models\Sys\Module;
use Illuminate\Database\Seeder;

class MenuDashboardSeeder extends Seeder
{
    public function run()
    {
        Module::create(
            [
                'label' => 'Dashboard',
                'name' => 'dashboard',
                'route' => 'dashboard',
                'is_header' => false,
                'order' => 0,
                'icon' => 'HomeIcon',
            ]);
    }

}
