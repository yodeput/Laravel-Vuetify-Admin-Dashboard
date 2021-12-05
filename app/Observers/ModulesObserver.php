<?php

namespace App\Observers;

use App\Models\Sys\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModulesObserver
{
    /**
     * Handle the Module "created" event.
     *
     * @param \App\Models\Module $menu
     * @return void
     */
    public function created(Module $menu)
    {
        $name = $menu->name;
        $permissions = Permission::insert([
            [
                'name' => 'read-' . $name,
                'display_name' => 'read',
                'guard_name' => 'api',
                'module_id' => $menu->id
            ],
            [
                'name' => 'create-' . $name,
                'display_name' => 'create',
                'guard_name' => 'api',
                'module_id' => $menu->id
            ],
            [
                'name' => 'update-' . $name,
                'display_name' => 'update',
                'guard_name' => 'api',
                'module_id' => $menu->id
            ],
            [
                'name' => 'delete-' . $name,
                'display_name' => 'delete',
                'guard_name' => 'api',
                'module_id' => $menu->id
            ]
        ]);
        $role = Role::findByName('superadmin');
        $role->givePermissionTo(Permission::all());
        $menu->assignRole($role);
    }

    /**
     * Handle the Module "updated" event.
     *
     * @param \App\Models\Module $menu
     * @return void
     */
    public function updated(Module $menu)
    {
        //
    }

    /**
     * Handle the Module "deleted" event.
     *
     * @param \App\Models\Module $menu
     * @return void
     */
    public function deleted(Module $menu)
    {
        //
    }

    /**
     * Handle the Module "restored" event.
     *
     * @param \App\Models\Module $menu
     * @return void
     */
    public function restored(Module $menu)
    {
        //
    }

    /**
     * Handle the Module "force deleted" event.
     *
     * @param \App\Models\Module $menu
     * @return void
     */
    public function forceDeleted(Module $menu)
    {
        //
    }
}
