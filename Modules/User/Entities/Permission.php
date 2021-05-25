<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'title'
    ];
    
    protected static function newFactory()
    {
        return \Modules\User\Database\factories\PermissionFactory::new();
    }
}
