<?php

namespace App\Models\Sys;

use Carbon\Traits\Timestamp;
use Spatie\Permission\Models\Permission;

class Role extends \Spatie\Permission\Models\Role
{
    use Timestamp;
    protected $appends = [
        'user_count', 'perm_count', 'perm_total'
    ];

    public function __construct() {
        parent::__construct();
        $this->table = config('tables.name.roles');

    }

    public function getUserCountAttribute()
    {
        return $this->users()->count();
    }

    public function getPermCountAttribute()
    {
        return $this->permissions()->count();
    }

    public function getPermTotalAttribute()
    {
        return Permission::get()->count();
    }


}
