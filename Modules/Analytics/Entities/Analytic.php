<?php

namespace Modules\Analytics\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analytic extends Model
{
    use HasFactory;

    protected $table = 'analytics__data';
    protected $fillable = ['user', 'views', 'url', 'ip', 'route', 'meta'];
    
    protected static function newFactory()
    {
        return \Modules\Analytics\Database\factories\AnalyticFactory::new();
    }
}
