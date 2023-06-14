<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\category;
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
            "user_id"=> $user->id,
            "category_id"=> category::factory()->create(),
            "title"=> $this->faker->text(200),
            "description"=> $this->faker->text(2000),
            "image"=>$this->faker->url(),
            "status"=> 1
        ]);

        $response->assertStatus(200);
    }

    public function  testUpdateBlog(){

        $user = User::where('user_id',1)->first();

        $response =  $this->actingAs($user)->postJson('/api/update-blog', [

            "blog_id"       => 7,
            "user_id"       => 1,
            "category_id"   => 4,
            "title"         => "What Is Meant By Lorem Ipsum In Website?",
            "description"   => "You can click on the ‘item to generate’ column and select the format you want content in.Below that, you can select if you want an HTML tag in your content or notAfter     that,   you can choose how many paragraphs you want in the ‘how many items to generate’ column.Then, you can choose the minimum and maximum words you want per sentence.Later, you can select the minimum and maximum sentences you want per paragraph.Finally, click on the button ‘generate’Taddalaa!",
            "image"         => "https://blogsimage.s3.amazonaws.com/pexels-craig-adderley-1563355.jpg",
            "status"        => 1

        ]);

        $response->assertStatus(200);

    }
}

