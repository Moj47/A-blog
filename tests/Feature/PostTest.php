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
    protected $middlewares=["web","auth"];

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCreateNewPost(): void
    {
        $post=Post::factory()->hasTags(rand(1,5))->create();
        $this->assertDatabaseHas('posts',$post->toArray());
    }
    public function testViewASinglePost()
    {
        $post=Post::factory()->hasTags(rand(1,5))->create();

        $reponse=$this->get(route('post.show',$post));

        $reponse->assertOk();

        $reponse->assertSee($post->name);
    }
    public function testViewAllPosts()
    {
        $posts=Post::factory()->count(5)->hasTags(rand(1,5))->create();

        $reponse=$this->get(route('home'));

        $reponse->assertOk();

        foreach($posts as $post)
        {
            $reponse->assertSee($post->name);
        }
    }
    public function testCreateApostWithStoreMethod()
    {
        $user=User::factory()->create();
        $category=Category::factory()->create();
        $post=Post::factory()->make(['category_id'=>$category->id])->toArray();
        $tags=Tag::factory()->count(rand(1,5))->make();
        $this->actingAs($user)
        ->post(route('admin.posts.store'), array_merge($post, [
            'tags' => $tags->pluck('name')->implode(' '),
        ]));
    $this->assertDatabaseHas('posts',[
        'title'=>$post['title'],
        'category_id'=>$post['category_id'],
    ]);
    }


}
