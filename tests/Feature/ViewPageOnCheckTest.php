<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\CreatesApplication;

class ViewPageOnCheckTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testViewPageOnCheck(): void
    {
        $domainName = "https://google.com";
        $id = DB::table('urls')->insertGetId([
            'name' => $domainName,
            'created_at' => CarbonImmutable::now(),
        ]);
        DB::table('url_checks')->insertGetId([
            'url_id' => $id,
            'status_code' => 200,
            'h1' => 'test h1',
            'title' => 'test title',
            'description' => 'test description',
            'created_at' => CarbonImmutable::now(),
        ]);
        $text = ['https://google.com', 200, 'test h1', 'test title', 'test description'];
        $response = $this
            ->get(route('urls.show', ['id' => $id]), [
                'domain' => ['name' => $domainName],
                'checks' => [
                    'status_code' => '200',
                    'h1' => 'test h1',
                    'title' => 'test title',
                    'description' => 'test description',
                ]]);
        $response->assertSeeText($text);
        $response->assertSessionHasNoErrors();
    }
}
