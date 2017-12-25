<?php

namespace Tests\Unit;

use App\Thread;
use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
	use DatabaseMigrations;

    protected $thread;

  function setUp()
	{
		parent::setUp();
		$this->thread = create(Thread::class);
	}

  /** @test */
  function a_thread_can_make_string_path()
  {
      $thread = create(Thread::class);

      $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
  }

    /** @test */
    function a_thread_can_add_a_reply()
    {
       $this->thread->addReply([
       		'body' => 'Foo',
       		'user_id' => 1
       ]);

       $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }

}
