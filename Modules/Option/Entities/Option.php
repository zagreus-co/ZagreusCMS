<?php

namespace Modules\Option\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Option extends Model
{
    use HasFactory, Translatable;
    protected $table = 'option__options';

    protected $fillable = [
        'tag',
        'type',
        'plain_data',
        'is_translatable'
    ];
    
    public $translatedAttributes = ['name', 'data', 'default'];

    protected static function newFactory()
    {
        return \Modules\Option\Database\factories\OptionFactory::new();
    }

}
