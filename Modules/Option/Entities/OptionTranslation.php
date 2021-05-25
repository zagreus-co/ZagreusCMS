<?php

namespace Modules\Option\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionTranslation extends Model
{
    use HasFactory;
    protected $table = 'option__option_translations';
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'data',
        'default'
    ];
    
    protected $casts = [
        'default'=> 'object'
    ];

    protected static function newFactory()
    {
        return \Modules\Option\Database\factories\OptionTranslationFactory::new();
    }
}
