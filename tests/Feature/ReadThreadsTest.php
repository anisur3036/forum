<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{
	use DatabaseMigrations;
    function setUp()
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    /** @test */
    function a_user_can_visit_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
       
    }

    /** @test */
    function a_user_can_view_indivisual_thread()
    {
        $this->get('/threads/'. $this->thread->channel->slug .'/'. $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_replies_that_are_associted_with_a_thread()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);
        $this->get('/threads/'. $this->thread->channel->slug .'/'. $this->thread->id)
            ->assertSee($reply->body);
    }

    /** @test */
    function a_thread_has_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    function a_user_can_filter_according_to_tag()
    {
        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create(User::class, ['name' => 'johnDoe']));

        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);
        $threadNotByJohn = create(Thread::class);

        $this->get('threads?by=johnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_popularity()
    {
        $threadWith2Replies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWith2Replies->id], 2);

        $threadWith3Replies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWith3Replies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

















}
