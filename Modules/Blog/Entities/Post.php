<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Modules\Keyword\Keywordable;

class Post extends Model
{
    use HasFactory, Translatable, Keywordable;

    protected $table = 'blog__posts';
    protected $fillable = [
        'cover',
        'category_id',
        'published',
        'can_comment',
        'template',
    ];
    public $translatedAttributes = ['slug', 'title', 'content'];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\PostFactory::new();
    }
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($post) {
            $post->comments()->delete();
        });
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function comments() {
        return $this->morphMany(\Modules\Comment\Entities\Comment::class, 'commentable');
    }
}
