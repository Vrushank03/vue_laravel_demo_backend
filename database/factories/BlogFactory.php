<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use App\Models\category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{

    protected $model = Blog::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            "blog_id"       => $this->faker->numberBetween(1,1000),
            "user_id"       => User::factory()->create()->user_id,
            "category_id"   => category::factory()->create()->category_id,
            "title"         => $this->faker->text(200),
            "description"   => $this->faker->text(200),
            "image"         => $this->faker->url(),
            "status"        => $this->faker->numberBetween(1,3)
        ];
    }
}
