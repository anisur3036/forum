<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpamTest extends TestCase
{
   /** @test */
   public function it_check_for_invalide_keyword()
   {
   		$spam = new Spam();
   		$this->assertFalse($spam->detect('Some important reply'));

   		$this->expectException('Exception');

   		$spam->detect('Yahoo customer support');
   }

   /** @test */
   public function it_checks_for_any_key_being_held_down()
   {
   		$spam = new Spam();

   		$this->expectException('Exception');

   		$spam->detect('Hello Worldddddddddddd');
   }
}
