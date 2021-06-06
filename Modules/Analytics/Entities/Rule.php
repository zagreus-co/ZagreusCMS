<?php

namespace Modules\Analytics\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'analytics__rules';
    protected $fillable = ['name', 'data'];
    
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Analytics\Database\factories\RuleFactory::new();
    }
}
