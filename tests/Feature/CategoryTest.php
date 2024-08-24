<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
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
        $Category = Category::factory()->create();
        $this->assertDatabaseHas('categories', $Category->toArray());
    }
    public function testViewAllCategories()
    {
        $categories = Category::factory()->count(5)->create();
        $user=User::factory()->create();

        $reponse=$this->actingAs($user)
        ->get(route('admin.categories.index'));

        $reponse->assertOk();

        foreach ($categories as $category) {
            $reponse->assertSee($category->name);
        }
    }
    public function testCreateACategoryWithStoreMethod()
    {
        $user = User::factory()->create();
        $category = Category::factory()->make();
        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category->toArray());
        $this->assertDatabaseHas('categories',$category->toArray());
        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }
    public function testUpdateATagWithUpdateMethod()
    {
        $category = Category::factory()->create();
        $category2 = Category::factory()->make()->toArray();

        $user=User::factory()->create();

        $this->actingAs($user)
        ->put(route('admin.categories.update',$category->id),$category2);

        $this->assertDatabaseHas('categories',$category2);

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }
    public function testDeleteACategoryWithDestoryMethod()
    {
        $category = Category::factory()->create();

        $user=User::factory()->create();

        $this->actingAs($user)
        ->delete(route('admin.categories.destroy',$category->id));

        $this->assertDatabaseMissing('categories',$category->toArray());

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }
}
