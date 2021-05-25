<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostTranslation extends Model
{
    use HasFactory;

    protected $table = 'blog__post_translations';
    protected $fillable = ['slug', 'title', 'content'];
    public $timestamps = false;
    
    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\PostTranslationFactory::new();
    }
}
