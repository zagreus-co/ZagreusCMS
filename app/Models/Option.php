<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
