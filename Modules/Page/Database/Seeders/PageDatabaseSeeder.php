<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use \Carbon\Carbon;
use Modules\Page\Entities\Page;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $faker = Factory::create();

        Page::create([
            'en'=> [
                'title'=> 'Hello world',
                'slug'=> \Str::slug('Hello world'),
                'content'=> str_replace("\n", "<br>", $faker->paragraphs(4, true)),
            ],
            'fa'=> [
                'title'=> 'سلام دنیا',
                'slug'=> \Str::slug('سلام دنیا'),
                'content'=> str_replace("\n", "<br>", $faker->paragraphs(4, true)),
            ],
            'published'=> 1,
        ]);
    }
}
