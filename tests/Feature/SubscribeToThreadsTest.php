<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;
   /** @test */
   function user_can_subscribe_to_threads()
   {
        $this->signIn();
        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

       $this->assertCount(1, $thread->subscriptions);


   }


    /** @test */
   public function only_throw_notification_if_other_user_give_reply()
   {
       $this->signIn();
       $thread = create('App\Thread');
       $this->post($thread->path() . '/subscriptions');
       $this->assertCount(0, auth()->user()->notifications);
       $thread->addReply([
           'user_id' => auth()->id(),
           'body' => 'Something'
       ]);

       $this->assertCount(0, auth()->user()->fresh()->notifications);
       $thread->addReply([
           'user_id' => create('App\User')->id,
           'body' => 'Something'
       ]);
       $this->assertCount(1, auth()->user()->fresh()->notifications);
   }

   /** @test */
   function a_user_can_see_there_notifications()
   {
       $this->signIn();
       create(DatabaseNotification::class);
       $this->assertCount(1, $this->getJson('/profiles/' . auth()->user()->name . '/notifications')->json());
   }
   
   /** @test */
   function a_user_can_clear_notifications()
   {
       $this->signIn();

       create(DatabaseNotification::class);

       $this->assertCount(1, auth()->user()->unreadNotifications);

       $notificationId = auth()->user()->unreadNotifications->first()->id;
       $this->delete('/profiles/'. auth()->user()->name . '/notifications/' . $notificationId);

       $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
   }
}
