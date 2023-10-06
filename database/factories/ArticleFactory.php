<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->word(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'content' =>  $this->faker->realTextBetween(200, 250),
            'like' => $this->faker->randomNumber()
        ];
    }
}
