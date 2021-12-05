<?php

namespace App\Models;

use App\Traits\Signature;
use App\Traits\Uuids;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use Timestamp, SoftDeletes, Signature, Uuids;

}
