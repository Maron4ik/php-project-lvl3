<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesApplication;
use Tests\TestCase;

class UrlsPathTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUrlsPath(): void
    {
        $response = $this->get(route('urls.index'));
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }
}
