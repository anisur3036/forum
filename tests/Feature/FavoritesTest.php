<?php

namespace Tests\Feature;

use App\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
	/** @test */
	public function a_guest_cant_favorite()
	{
		$this->withExceptionHandling();
		$this->post('/replies/1/favorites')
			->assertRedirect('/login');
	}
	
    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
    	$user = $this->signIn();
    	$reply = create('App\Reply');
    	$this->post('/replies/' . $reply->id . '/favorites');
    	$this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply_only_one_time()
    {
    	$user = $this->signIn();
    	$reply = create('App\Reply');
    	try {
	    	$this->post('/replies/' . $reply->id . '/favorites');
	    	$this->post('/replies/' . $reply->id . '/favorites');
    	} catch (\Exception $e) {
    		$this->fail('Only one reply possible');
    	}
    	$this->assertCount(1, $reply->favorites);
    }
    
}
