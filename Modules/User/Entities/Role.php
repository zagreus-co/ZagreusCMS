<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    
    protected static function newFactory()
    {
        return \Modules\User\Database\factories\RoleFactory::new();
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function accessList() {
        return $this->hasMany(AccessList::class);
    }

    public function categoryExist($id) {
        return !! $this->accessList()
            ->whereRoleId($this->id)
            ->whereAccessableType('Modules\Blog\Entities\Category')
            ->whereAccessableId($id)
            ->count();
    }
}
