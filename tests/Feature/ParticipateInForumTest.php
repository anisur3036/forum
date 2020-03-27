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
		$this->signIn();
		$thread = create(Thread::class);
		$reply = make(Reply::class, [
			'body' => 'Yahoo Customer Support'
		]);
		
		$this->expectException(\Exception::class);

		$this->post($thread->path() . '/replies', $reply->toArray());
	}
}
