<?php


namespace App\Traits;


trait HasChildren
{
    public function childrens() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children() {
        return $this->childrens()->with('children');
    }

}
