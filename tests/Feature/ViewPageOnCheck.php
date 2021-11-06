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

class ViewPageOnCheck extends TestCase
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
        $checks = DB::table('url_checks')->insertGetId([
            'url_id' => $id,
            'created_at' => CarbonImmutable::now(),
        ]);
        $response = $this
            ->get('urls/1', ['url' => ['name' => $domainName]]);
        $response->assertSessionHasNoErrors();
    }
}
