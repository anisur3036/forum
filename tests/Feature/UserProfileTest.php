<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserProfileTest extends TestCase
{
    /** @test */
    public function a_user_has_profile_page()
    {
    	$user = create('App\User');
    	$this->get('/profiles/' . $user->name)
    		->assertSee($user->name);
    }

    /** @test */
    public function display_all_thread_when_go_to_his_profile_page()
    {
    	$user = create('App\User');
    	$thread = create('App\Thread', ['user_id' => $user->id]);
    	$this->get('/profiles/' . $user->name)
    		->assertSee($thread->title)
    		->assertSee($thread->body);
    }
}