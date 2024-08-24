<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    protected $middlewares = ["web", "auth"];

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCreateNewCategory(): void
    {
        $tags = Tag::factory()->create();
        $this->assertDatabaseHas('tags', $tags->toArray());
    }
    public function testViewAllTags()
    {
        $tags = Tag::factory()->count(5)->create();
        $user=User::factory()->create();

        $reponse=$this->actingAs($user)
        ->get(route('admin.tags.index'));

        $reponse->assertOk();

        foreach ($tags as $tag) {
            $reponse->assertSee($tag->name);
        }
    }
    public function testCreateATagWithStoreMethod()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->make();
        $this->actingAs($user)
            ->post(route('admin.tags.store'), $tag->toArray());

        $this->assertDatabaseHas('tags',$tag->toArray());
        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }

    public function testUpdateATagWithUpdateMethod()
    {
        $tag = Tag::factory()->create();
        $tag2 = Tag::factory()->make()->toArray();

        $user=User::factory()->create();

        $this->actingAs($user)
        ->put(route('admin.tags.update',$tag->id),$tag2);

        $this->assertDatabaseHas('tags',$tag2);

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }

    public function testDeleteATagWithDestoryMethod()
    {
        $tag=Tag::factory()->create();

        $user=User::factory()->create();

        $response=$this->actingAs($user)
        ->delete(route('admin.tags.destroy',$tag->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('tags',$tag->toArray());

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }

}
