<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'filename', 'tag', 'permissions'];
    
    protected static function newFactory()
    {
        return \Modules\Media\Database\factories\MediaFactory::new();
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function mediaable() {
        return $this->morphTo();
    }

    public function load($tag, $default = 'themes/ArtesheSorkh/images/404-cover-image.jpg') {
        // if ($video->medias()->whereTag('cover')->first())
        //     $image = $video->medias()->whereTag('cover')->first()->filename;

        return 5;
    }
}
