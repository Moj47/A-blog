<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $category = Category::factory()->create();
    return [
        'title' => $this->faker->title(),
        'text' =>$this->faker->text(),
        'category_id'=>$category->id,
        'image' => UploadedFile::fake()->image('test.jpg', 400, 400),
    ];

}

}
