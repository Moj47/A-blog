<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    protected $middlewares = ["web", "auth"];

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCreateNewPost(): void
    {
        $post = Post::factory()->hasTags(rand(1, 5))->create();
        $this->assertDatabaseHas('posts', $post->toArray());
    }
    public function testViewASinglePost()
    {
        $post = Post::factory()->hasTags(rand(1, 5))->create();

        $reponse = $this->get(route('post.show', $post));

        $reponse->assertOk();

        $reponse->assertSee($post->name);
    }
    public function testViewAllPosts()
    {
        $posts = Post::factory()->count(5)->hasTags(rand(1, 5))->create();

        $reponse = $this->get(route('home'));

        $reponse->assertOk();

        foreach ($posts as $post) {
            $reponse->assertSee($post->name);
        }
    }
    public function testCreateApostWithStoreMethod()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->make(['category_id' => $category->id])->toArray();
        $tags = Tag::factory()->count(rand(1, 5))->make();
        $this->actingAs($user)
            ->post(route('admin.posts.store'), array_merge($post, [
                'tags' => $tags->pluck('name')->implode(' '),
            ]));
        $this->assertDatabaseHas('posts', [
            'title' => $post['title'],
            'category_id' => $post['category_id'],
        ]);
    }

    public function testUpdateApostWithUpdateeMethod()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->hasTags(rand(1, 5))->create(['category_id' => $category->id]);

        $user = User::factory()->create();
        $category2 = Category::factory()->create();
        $newPost = Post::factory()->make(['category_id' => $category2->id])->toArray();
        $newTags = Tag::factory()->count(rand(1, 5))->make();

        $response = $this->actingAs($user)
            ->put(route('admin.posts.update', $post->id), array_merge($newPost, [
                'tags' => $newTags->pluck('name')->implode(' '),
            ]));

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $newPost['title'],
            'text' => $newPost['text'],
            'category_id' => $newPost['category_id'],
        ]);

        $this->assertEquals($newTags->pluck('name'), $post->tags()->pluck('name'));
    }
    public function testDeleteAPostWithDestroyMethod()
    {
        $this->withExceptionHandling();
        $post=Post::factory()->hasTags(rand(1,5))->create();
        $this->assertDatabaseHas('posts',$post->toArray());

        $user=User::factory()->create();
        $this->actingAs($user)
        ->delete(route('admin.posts.delete',$post->id));
        $this->assertDatabaseMissing('posts',$post->toArray());
    }
}
