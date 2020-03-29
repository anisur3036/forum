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
	function a_reply_requires_a_body()
	{
		$this->withExceptionHandling()->signIn();

		$thread = create(Thread::class);
		$reply = make(Reply::class, ['body' => null]);

		$this->post($thread->path() . '/replies', $reply->toArray())
			->assertSessionHasErrors('body');
	}

	/** @test */
	public function replies_that_contain_spam_may_not_be_created()
	{
		$this->withExceptionHandling();
		$this->signIn();
		$thread = create(Thread::class);
		$reply = make(Reply::class, [
			'body' => 'Yahoo Customer Support'
		]);
		
		$this->json('post', $thread->path() . '/replies', $reply->toArray())
			->assertStatus(422);
	}

	/** @test */
	public function users_may_not_reply_more_than_one_reply_in_munites()
	{
		$this->withExceptionHandling();

		$this->signIn();
		$thread = create(Thread::class);
		$reply = make(Reply::class, [
			'body' => 'This is sample reply'
		]);
		$this->post($thread->path() . '/replies', $reply->toArray())
			->assertStatus(200);
		$this->post($thread->path() . '/replies', $reply->toArray())
			->assertStatus(429);
	}
}
