<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesApplication;
use Tests\TestCase;

class IdPathTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIdPath(): void
    {
        $response = $this->get('/urls/20147887');
        $response->assertStatus(404);
        $response->assertSessionHasNoErrors();
    }
}
