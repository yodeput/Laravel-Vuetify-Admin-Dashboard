<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Model;

class Activity extends \Spatie\Activitylog\Models\Activity
{

    public function getTable()
    {
        return config('tables.name.activities', parent::getTable());
    }

    public function user(){
        return $this->hasOne(User::class,'id','causer_id');
    }
}
