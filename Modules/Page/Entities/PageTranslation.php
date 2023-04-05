<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageTranslation extends Model
{
    use HasFactory;

    protected $table = 'page__page_translations';
    protected $fillable = ['slug', 'title', 'content'];
    public $timestamps = false;

}
