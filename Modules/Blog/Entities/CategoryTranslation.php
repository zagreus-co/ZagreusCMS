<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'blog__category_translations';
    protected $fillable = ['slug', 'title'];
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\CategoryableFactory::new();
    }

}
