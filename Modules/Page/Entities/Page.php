<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Page extends Model
{
    use HasFactory, Translatable;
    protected $table = 'page__pages';
    public $translatedAttributes = ['slug', 'title', 'content'];
    protected $fillable = ['can_comment', 'display_in_header', 'published', 'template'];
    
    protected static function newFactory()
    {
        return \Modules\Page\Database\factories\PageFactory::new();
    }

    public function comments() {
        return $this->morphMany(\Modules\Comment\Entities\Comment::class, 'commentable');
    }

    public function keywords() {
        return $this->morphMany(\Modules\Keyword\Entities\Keyword::class, 'keywordable');
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
