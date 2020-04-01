<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
    	$anis = create('App\User', ['name' => 'Anis']);

    	$this->signIn($anis);

    	$tabu = create('App\User', ['name' => 'Tabu']);

    	$thread = create('App\Thread');

    	$reply = make('App\Reply', [
    		'body' => '@Tabu you see my @Anisrah reply.'
    	]);

    	$this->json('post', $thread->path() . '/replies', $reply->toArray());

    	$this->assertCount(1, $tabu->notifications);
    }
}