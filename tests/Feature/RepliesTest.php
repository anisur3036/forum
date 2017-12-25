<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RepliesTest extends TestCase
{
	use DatabaseMigrations;
    /** @test */
    function reply_has_an_owner()
    {
        $reply = create(Reply::class);
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
