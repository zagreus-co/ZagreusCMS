<?php

namespace Modules\Keyword\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['keyword'];
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Keyword\Database\factories\KeywordFactory::new();
    }

    public function keywordable() {
        return $this->morphTo();
    }
}
