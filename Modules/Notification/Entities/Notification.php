<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'message',
        'seen',
        'visible'
    ];

    public function seen() {
        return $this->update([
            'seen'=>true
        ]);
    }

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
}
