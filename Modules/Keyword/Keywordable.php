<?php

namespace Modules\Keyword;

use Modules\Keyword\Entities\Keyword;

trait Keywordable {

    public static function bootKeywordable() {
        static::deleted(function ($model) {
            $model->keywords()->delete();
        });
    }

    public function keywords() {
        return $this->morphMany(\Modules\Keyword\Entities\Keyword::class, 'keywordable');
    }
}