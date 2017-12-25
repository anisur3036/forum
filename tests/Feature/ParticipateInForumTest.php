<?php

namespace Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;
	/** @test */
	function an_authenticated_user_may_participate_in_forum_threads()
	{
       $this->signIn();
	   //And an exisiting thread
	   $thread = create(Thread::class);

	   //When the users adds a reply to the thread
	   $reply = create(Reply::class);

	   //When the users adds a reply to the thread
	   $this->post($thread->path() . '/replies', $reply->toArray());

	   //then should see this reply on that page 
	   $this->get($thread->path())
	   	->assertSee($reply->body);
	}

	/** @test */
	function a_reply_requires_a_body()
	{
		$this->withExceptionHandling()->signIn();

		$thread = create(Thread::class);
		$reply = make(Reply::class, ['body' => null]);

		$this->post($thread->path() . '/replies', $reply->toArray())
			->assertSessionHasErrors('body');
	}
}
