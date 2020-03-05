<?php

namespace Tests\Unit;

use App\Activity;
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

         $activity = Activity::first();

         $this->assertEquals($activity->subject->id, $thread->id);
   }

   /** @test */
   public function it_record_activity_when_a_reply_created()
   {
      $this->signIn();

      $reply = create('App\Reply');

      $this->assertEquals(2, Activity::count());;


   }
}
