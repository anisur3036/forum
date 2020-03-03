<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_authenticated_user_may_create_forum_thread()
    {
        $this->signIn();
        
        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
			->assertSee($thread->title)
        	->assertSee($thread->body);
    }

    /** @test */
    function guests_may_not_create_thread()
    {
    	//$user = create(User::class);
        $this->withExceptionHandling();
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    function guest_can_not_see_thread_create_page()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
        
        $this->publishThread(['channel_id' => 3])
            ->assertSessionHasErrors('channel_id');


    }

   public function publishThread($fields = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $fields);
        return $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function an_authrize_user_can_delete_thread()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function an_unauthrized_user_can_not_delete_any_thread()
    {
        $this->withExceptionHandling();
        $thread = create('App\Thread');
        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
        
    }
}
