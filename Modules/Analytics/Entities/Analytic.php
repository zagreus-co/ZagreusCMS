<?php

namespace Modules\Analytics\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class analytic extends Model
{
    use HasFactory;

    protected $fillable = ['user', 'views', 'url', 'route', 'meta'];
    
    protected static function newFactory()
    {
        return \Modules\Analytics\Database\factories\AnalyticFactory::new();
    }
}
