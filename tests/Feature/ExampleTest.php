<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMainPath(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testUrlsPath(): void
    {
        $response = $this->get('/urls');

        $response->assertStatus(200);
    }

    public function testIdPath()
    {
        $response = $this->get('/urls/22');

        $response->assertStatus(403);
    }

    public function testIdPathForbidden(): void
    {
        $response = $this->get('/urls/fghf');

        $response->assertForbidden();
    }

    public function testCreateUrl(): void
    {
        $domainName = "https://google.com";
        $response = $this
            ->followingRedirects()
            ->post('/', ['url' => ['name' => $domainName]])
            ->assertStatus(200);

        $response->assertSeeText($domainName);

        $this->assertDatabaseHas('urls', [
            'name' => 'https://google.com',
        ]);
    }
    public function testViewPage(): void
    {
        $domainName = "https://google.com";
        $id = DB::table('urls')->insertGetId([
            'name' => $domainName,
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now()
        ]);

        $response = $this
            ->post('/', ['url' => ['name' => $domainName]])
            ->assertRedirect(route('url.show', ['id' => $id]));
;

//        $response->assertSeeText($domainName);

        $this->assertDatabaseCount('urls', 1);
    }
}
