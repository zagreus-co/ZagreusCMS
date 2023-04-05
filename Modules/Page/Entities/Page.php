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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($page) {
            $page->comments()->delete();
        });
    }

    public function comments() {
        return $this->morphMany(\Modules\Comment\Entities\Comment::class, 'commentable');
    }
}
