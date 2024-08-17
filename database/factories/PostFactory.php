<?php

namespace Database\Factories;

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
    $image = UploadedFile::fake()->image('post_image.jpg', 640, 480);

    return [
        'title' => $this->faker->title(),
        'text' =>$this->faker->text(),
        'image' => UploadedFile::fake()->image('file1.png', 600, 600),
    ];
}
}
