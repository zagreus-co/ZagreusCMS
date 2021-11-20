<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
