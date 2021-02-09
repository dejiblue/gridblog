<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Blog;

class PostTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;
    /**
     * @test
     */
    public function test_it_returns_a_index_page_for_post_listings()
    {
        $this->get('/posts')->assertOk()
             ->assertViewIs('welcome');
    }

    /**
     * @test
     */
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * @test
     */
    public function a_visitor_can_able_to_login()
    {
        $user = factory(User::class)->create();
        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
        $response = $this->actingAs($user)->get('/home');
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('here-we-go-now'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /**
     * @test
     */
    public function test_it_returns_create_view_for_post()
    {
        $this->be($user = factory(User::class)->create());
        $this->get("/create/post")
             ->assertOk()
             ->assertViewIs('post_create');
    }

    /**
     * @test
     */
    public function test_it_returns_validation_error_for_title_stating_required()
    {
        $this->be($user = factory(User::class)->create());
        $this->post('/store/post', array_merge($this->postData(), ['title' => null]))
             ->assertSessionHasErrors('title');

        $this->assertDatabaseMissing('blogs', [
            'id' => 1,
            'title' => '',
        ]);
    }

    /**
     * @test
     */
    public function test_it_returns_validation_error_for_body_stating_required()
    {
        $this->be($user = factory(User::class)->create());
        $this->post('/store/post', array_merge($this->postData(), ['body' => null]))
             ->assertSessionHasErrors('body');
        $this->assertDatabaseMissing('blogs', [
            'id' => 1,
            'body' => '',
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_create_a_new_post_from_a_post_request()
    {
        $this->be($user = factory(User::class)->create());
        $this->post('/store/post', $this->postData())
             ->assertStatus(302)
             ->assertSessionHas('status', 'Post has been created.');

        $this->assertDatabaseHas('blogs', [
            'id' => 1,
            'author' => 1,
            'title' => 'A new post has been created.',
            'body' => 'This new post is being driven by tests.',
        ]);
    }

    /**
     * @test
     */
    public function test_it_returns_edit_view_for_post()
    {
        $this->be($user = factory(User::class)->create());
        $post = factory(Blog::class)->create();
        $this->get("/edit/post/{$post->id}")
             ->assertViewIs('edit_form');
    }

    /**
     * @test
     */
    public function test_it_is_able_to_update_an_existing_post_from_a_resource_object()
    {
        $this->be($user = factory(User::class)->create());
        $post = factory(Blog::class)->create();
        $this->put("/update/post/{$post->id}", $this->postData())
             ->assertStatus(302)
             ->assertSessionHas('status', 'Post has been successfully updated.');

        $this->assertDatabaseHas('blogs', [
            'id' => 1,
            'author' => 1,
            'title' => 'A new post has been created.',
            'body' => 'This new post is being driven by tests.',
        ]);
    }

    /**
     * @test
     */
    public function test_it_is_able_to_delete_an_existing_post()
    {
        $this->be($user = factory(User::class)->create());
        $post = factory(Blog::class)->create();
        $this->delete("/delete/post/{$post->id}")
             ->assertStatus(302)
             ->assertSessionHas('status', 'Post has been successfully deleted.');
    }

    private function postData()
    {
        return [
            'author' => 1,
            'title' => 'A new post has been created.',
            'body' => 'This new post is being driven by tests.',
        ];
    }
}
