<?php

namespace Modules\Keyword\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['keyword', 'keywordable_id', 'keywordable_type'];
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Keyword\Database\factories\KeywordFactory::new();
    }

    public function keywordable() {
        return $this->morphTo();
    }

    public function createKeyword(array $keywords, $keywordable_id, $keywordable_type) {
        $this->where('keywordable_id', $keywordable_id)
            ->where('keywordable_type', $keywordable_type)->delete();
        foreach ($keywords as $keyword) {
            $this->create([
                'keyword'=> $keyword,
                'keywordable_id'=> $keywordable_id,
                'keywordable_type'=> $keywordable_type,
            ]);
        }
    }
}
