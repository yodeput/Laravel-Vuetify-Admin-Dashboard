<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __invoke()
    {
        return auth()->user()->getAllPermissions()->pluck('name');
    }

    public function count () {
        return Permission::count();
    }
    public function all () {
        return Permission::all();
    }

}
