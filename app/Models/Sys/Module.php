<?php

namespace App\Models\Sys;

use App\Models\BaseModel;
use App\Traits\HasChildren;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class Module extends BaseModel
{
    use HasChildren, HasRoles;

    public function getTable()
    {
        return config('tables.name.modules', parent::getTable());
    }

    protected $guard_name = 'api';
    protected $fillable = [
        'name',
        'label',
        'route',
        'icon',
        'parent_id',
        'order',
        'is_header',
        'is_group',
    ];

    protected $casts = [
        'is_header' => 'boolean',
        'is_group' => 'boolean',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
