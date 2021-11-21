<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Post extends Model
{
    use HasFactory, Translatable;

    protected $table = 'blog__posts';
    protected $fillable = [
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
            $post->medias()->delete();
            $post->keywords()->delete();
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

    public function keywords() {
        return $this->morphMany(\Modules\Keyword\Entities\Keyword::class, 'keywordable');
    }

    public function medias() {
        return $this->morphMany(\App\Models\Media::class, 'mediaable');
    }

    public function scores() {
        return $this->morphMany(\Modules\Score\Entities\Score::class, 'scoreable');
    }
    public function getPositiveScoresAttribute() {
        return $this->scores()->whereScore(1)->get()->pluck('score')->sum();
    }
    public function getNegativeScoresAttribute() {
        return $this->scores()->whereScore(-1)->get()->pluck('score')->sum();
    }

    public function getCoverAttribute() {
        return $this->medias()->whereTag('cover')->first()->filename ?? null;
    }

    public function getAttachmentsAttribute() {
        return $this->medias()->whereTag('attachment')->get() ?? null;
    }
}
