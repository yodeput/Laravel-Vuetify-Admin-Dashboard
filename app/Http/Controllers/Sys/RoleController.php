<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\Module;
use App\Models\Sys\Role;
use App\Traits\ActivityTraits;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RoleController extends Controller
{
    use ActivityTraits, CustomResponse;

    public function __invoke()
    {
        return auth()->user();
    }

    public function filter(Request $request)
    {
        $query = Role::with('permissions');

        if ($request->search) {
            $search = strtolower(trim($request->search));
            $query->whereRaw('LOWER(name) LIKE ? ', ['%' . $search . '%'])
                ->orWhereRaw('LOWER(display_name) LIKE ? ', ['%' . $search . '%']);
        }

        $roles = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.desc') === 'true' ? 'DESC' : 'ASC')
            ->paginate($request->input('pagination.per_page'));


        return $roles;
    }

    public function all()
    {
        return Role::all();
    }

    public function show($role)
    {
        $role = Role::findOrFail($role)->load('permissions');
        $modules = Module::with(['children', 'children.permissions'])->has('permissions')->whereNull('parent_id')->orderBy('order')->get();

        foreach ($modules as $key => $value) {
            foreach ($value->children as $key2 => $value2) {
                foreach ($value2->permissions as $ke2 => $val2) {
                    foreach ($role->permissions as $k2 => $v2) {
                        if ($v2->name == $val2->name) {
                            $val2->allow = true;
                        }
                    }
                }
            }

            foreach ($value->permissions as $ke => $val) {
                foreach ($role->permissions as $k => $v) {
                    if ($v->name == $val->name) {
                        $val->allow = true;
                    }
                }
            }


        }
        $role->modulesPermissions = $modules;
        return $this->successResponse($role);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'display_name' => 'required|string|unique:sysrls'
        ]);

        $name = preg_replace('/\s+/', '_', strtolower(trim($request->display_name)));

        $role = Role::create([
            'name' => $name,
            'display_name' => $request->display_name
        ]);

        $permissions = [];
        foreach ($request->modulesPermissions as $key => $value) {
            foreach ($value['permissions'] as $ke => $val) {
                if (isset($val['allow']) && $val['allow']) {
                    array_push($permissions, ['name' => $val['name']]);
                }
            }
        }

        $role->givePermissionTo($permissions);
        $this->logCreateActivity($role, 'Role: ' . $role->display_name);
        return $this->successResponse($role, 'Role Created', 201);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:sysrls,name,' . $request->id,
            'display_name' => 'required|string|unique:sysrls,display_name,' . $request->id,
            'modulesPermissions' => 'array'
        ]);

        $role = Role::findOrFail($request->id);
        $beforeUpdateValues = $role->toArray();

        if ($role->name != $request->name) {
            $role->name = $request->name;
        }

        if ($role->display_name != $request->display_name) {
            $role->display_name = $request->display_name;
        }

        $permissions = [];
        foreach ($request->modulesPermissions as $key => $value) {
            foreach ($value['children'] as $ke => $valC) {
                /*try {
                    $permission = Permission::create(['guard_name' => $val['guard_name'], 'name' => $val['name'], 'display_name' => $val['display_name'],]);
                } catch (PermissionAlreadyExists $e){

                }*/
                foreach ($valC['permissions'] as $ke2 => $valCC) {
                    if (isset($valCC['allow']) && $valCC['allow']) {
                        array_push($permissions, ['name' => $valCC['name']]);
                    }
                }
            }
            foreach ($value['permissions'] as $ke => $val) {
                /*try {
                    $permission = Permission::create(['guard_name' => $val['guard_name'], 'name' => $val['name'], 'display_name' => $val['display_name'],]);
                } catch (PermissionAlreadyExists $e){

                }*/
                if (isset($val['allow']) && $val['allow']) {
                    array_push($permissions, ['name' => $val['name']]);
                }
            }
        }


        $role->syncPermissions($permissions);
        $this->logUpdateActivity($role, 'Role: ' . $role->display_name);
        $role->save();
        $afterUpdateValues = $role->getChanges();

        return $this->successResponse($role, 'Role Updated');

    }

    public function destroy($role)
    {
        $this->logDeleteActivity($role, 'Role: ' . $role->display_name);

        Role::destroy($role);
        return $this->successResponse(null, 'Role Deleted');
    }


    public function count()
    {
        return Role::count();
    }

    public function getRoleModulesPermissions($role)
    {
        $role = Role::with('permissions', 'users')->findOrFail($role);
        $modules = Module::with(['children', 'children.permissions'])->has('permissions')->whereNull('parent_id')->orderBy('name')->get();

        foreach ($modules as $key => $value) {
            foreach ($value->children as $key2 => $value2) {
                foreach ($value2->permissions as $ke2 => $val2) {
                    foreach ($role->permissions as $k2 => $v2) {
                        if ($v2->name == $val2->name) {
                            $val2->allow = true;
                        }
                    }
                }
            }

            foreach ($value->permissions as $ke => $val) {
                foreach ($role->permissions as $k => $v) {
                    if ($v->name == $val->name) {
                        $val->allow = true;
                    }
                }
            }


        }
        $role->modulesPermissions = $modules;
        return $role;
    }
}
