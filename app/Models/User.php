<?php

namespace App\Models;

use App\Notifications\MailResetPasswordNotification;
use App\Notifications\MailVerificationNotification;
use App\Traits\Signature;
use App\Traits\Uuids;
use Carbon\Traits\Timestamp;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable, HasRoles;
    use Timestamp, SoftDeletes, Signature, Uuids;

    public function getTable()
    {
        return config('tables.name.users', parent::getTable());
    }

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'address',
        'phone',
        'image',
    ];
    protected $guard_name = 'api';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAllPermissionsAttribute()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }
        return $permissions;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($this->name, $token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new MailVerificationNotification($this->id, $this->name));
    }
}
