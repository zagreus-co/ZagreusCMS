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

        return $this->afterCreating(function (\Modules\Blog\Entities\Post $post) {
            $post->medias()->create([
                'user_id'=> 1,
                'tag'=> 'cover',
                'filename'=> asset('img/cms.jpg')
            ]);
        });
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
            'en'=> [
                'title'=> $en_title,
                'slug'=> \Str::slug($en_title),
                'content'=> $this->faker->paragraphs(20, true),
            ],
            'fa'=> [
                'title'=> $fa_title,
                'slug'=> \Str::slug($fa_title),
                'content'=> $fa_faker->paragraphs(20, true),
            ],
        ];
    }
}

