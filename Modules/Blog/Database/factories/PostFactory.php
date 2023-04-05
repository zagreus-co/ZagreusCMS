<?php
namespace Modules\Blog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Blog\Entities\Post::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fa_faker = \Faker\Factory::create('fa_IR');
        $en_title = $this->faker->words(3, true);
        $fa_title = $fa_faker->words(3, true);

        return [
            'user_id'=> 1,
            'category_id'=> rand(1,2),
            'published'=> 1,
            'cover'=> $this->getCover(),
            'en'=> [
                'title'=> $en_title,
                'slug'=> generateSlug($en_title),
                'content'=> $this->faker->paragraphs(20, true),
            ],
            'fa'=> [
                'title'=> $fa_title,
                'slug'=> generateSlug($fa_title),
                'content'=> $fa_faker->paragraphs(20, true),
            ],
        ];
    }

    protected function getCover(): string {
        $cover_list = [
            themeAsset('img/1.webp'),
            themeAsset('img/2.webp'),
            themeAsset('img/3.webp'),
            themeAsset('img/4.webp'),
            themeAsset('img/5.webp'),
            themeAsset('img/6.webp'),
            themeAsset('img/7.webp'),
        ];

        return $cover_list[ rand( 0, (count($cover_list) - 1) ) ];
    }
}

