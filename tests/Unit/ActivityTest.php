<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
   /** @test */
   public function records_activity_when_a_thread_created()
   {
   		$this->signIn();

   		$thread = create('App\Thread');

   		$this->assertDatabaseHas('activities', [
   			'type' => 'created_thread',
   			'user_id' => auth()->id(),
   			'subject_id' => $thread->id,
   			'subject_type' => 'App\Thread'
   		]);
   }
}
