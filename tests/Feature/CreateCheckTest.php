<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\CreatesApplication;
use Tests\TestCase;

use function route;

class CreateCheckTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateCheck(): void
    {
        $domainName = "https://google.com";
        $id = DB::table('urls')->insertGetId([
            'name' => $domainName,
            'created_at' => CarbonImmutable::now(),
        ]);
        $testHtml = file_get_contents(__DIR__ . '/../fixtures/test.html');
        Http::fake(function () use ($testHtml): PromiseInterface {
            return Http::response((string)$testHtml);
        });
        $response = $this
            ->followingRedirects()
            ->post(route('checks.store', ['id' => $id]))
            ->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('url_checks', [
            'status_code' => 200,
            'h1' => 'test h1', //TODO
            'title' => 'test title',  //TODO
            'description' => 'test description',  //TODO
        ]);
    }
}
