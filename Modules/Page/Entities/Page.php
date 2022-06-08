<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Modules\Keyword\Keywordable;

class Page extends Model
{
    use HasFactory, Translatable, Keywordable;
    protected $table = 'page__pages';
    public $translatedAttributes = ['slug', 'title', 'content'];
    protected $fillable = ['can_comment', 'display_in_header', 'published', 'template'];
    
    protected static function newFactory()
    {
        return \Modules\Page\Database\factories\PageFactory::new();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($blog) {
            $blog->medias()->delete();
            $page->comments()->delete();
            $page->scores()->delete();
        });
    }

    public function comments() {
        return $this->morphMany(\Modules\Comment\Entities\Comment::class, 'commentable');
    }
    
    public function medias() {
        return $this->morphMany(\Modules\Media\Entities\Media::class, 'mediaable');
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
}
