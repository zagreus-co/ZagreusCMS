<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use \Modules\Blog\Entities\Post;
use \Modules\Blog\Entities\Category;

class BlogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Category::create([
            'en'=> ['slug'=> 'website',
            'title'=> 'Website'],
            'fa'=> ['slug'=> 'website',
            'title'=> 'وبسایت']
        ]);
        Category::create([
            'en'=> ['slug'=> 'news',
            'title'=> 'News'],
            'fa'=> ['slug'=> 'اخبار',
            'title'=> 'اخبار']
        ]);
        
        Post::factory()->count(7)->create();
    }
}
