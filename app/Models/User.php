<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'full_name',
        'country_code',
        'number',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(\Modules\User\Entities\Role::class);
    }

    public function hasPermission($permission) {
        if (is_null($this->role)) return false;
        return in_array($permission->tag ?? $permission, $this->role->permissions->pluck('tag')->toArray());
    }

    public function posts() {
        return $this->hasMany(\Modules\Blog\Entities\Post::class);
    }

    public function notifications() {
        return $this->hasMany(\Modules\Notification\Entities\Notification::class);
    }
}
