<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'filename', 'tag', 'permissions'];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function mediaable() {
        return $this->morphTo();
    }
}
