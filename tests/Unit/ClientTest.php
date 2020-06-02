<?php

namespace Techneved\Client\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase 
{
    use RefreshDatabase;

    /** @test */
    public function create_admin_from_factory()
    {
        $client = $this->createClient();
        $this->assertEquals(1, $client->count());
       
    }
}