<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use HasFactory, Translatable;

    protected $table = 'blog__categories';
    protected $fillable = ['parent_id'];
    public $translatedAttributes = ['slug', 'title'];
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\CategoryFactory::new();
    }
    
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    
    public function child() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    
    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function medias() {
        return $this->morphMany(\Modules\Media\Entities\Media::class, 'mediaable');
    }
}
