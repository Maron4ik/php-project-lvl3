<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesApplication;
use Tests\TestCase;

class PathForbiddenTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIdPathForbidden(): void
    {
        $response = $this->get('/urls/forbidden');
        $response->assertStatus(404);
        $response->assertSessionHasNoErrors();
    }
}
