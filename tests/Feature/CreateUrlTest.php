<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesApplication;
use Tests\TestCase;

class CreateUrlTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUrl(): void
    {
        $domainName = "https://google.com";
        $response = $this
            ->followingRedirects()
            ->post('/urls', ['url' => ['name' => $domainName]])
            ->assertStatus(200);
        $response->assertSessionHasNoErrors();

        $response->assertSeeText($domainName);

        $this->assertDatabaseHas('urls', [
            'name' => 'https://google.com',
        ]);
    }
}
