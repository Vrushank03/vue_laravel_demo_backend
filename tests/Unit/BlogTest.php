<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\category;
use App\Models\Blog;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class BlogTest extends TestCase
{

    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function testBlogData()
    {
        // $user = User::where('user_id',1)->first();
        $user = User::factory()->create();

        $response =  $this->actingAs($user)->postJson('/api/blogs', ['category_id' => '1']);

        $response->assertStatus(200);
    }

    public function testCreateBlog()
    {

        $user = User::factory()->create();

        $response =  $this->actingAs($user)->postJson('/api/create-blog', [

            "user_id"       => $user->user_id,
            "category_id"   => category::factory()->create()->category_id,
            "title"         => $this->faker->text(200),
            "description"   => $this->faker->text(2000),
            "image"         =>$this->faker->url(),
            "status"        => $this->faker->numberBetween(1,3)

        ]);

        $response->assertStatus(200);
    }

    public function  testUpdateBlog(){

        $user = User::where('user_id',1)->first();

        $response =  $this->actingAs($user)->postJson('/api/update-blog', [

            "blog_id"       => 7,
            "user_id"       => $user->user_id,
            "category_id"   => category::factory()->create()->category_id,
            "title"         => $this->faker->text(200),
            "description"   => $this->faker->text(200),
            "image"         => $this->faker->url(),
            "status"        => $this->faker->numberBetween(1,3)

        ]);

        $response->assertStatus(200);

    }

    public function testDeleteBlog(){

        $user = User::factory()->create();
        $blog = Blog::factory()->create()->blog_id;

        $response = $this->actingAs($user)->postJson('/api/delete-blog/' . $blog);
        $response->assertStatus(200);

    }
}

