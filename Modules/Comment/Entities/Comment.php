<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_contact',
        'comment',
        'parent_id',
        'published'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Comment\Database\factories\CommentFactory::new();
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function child() {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
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
