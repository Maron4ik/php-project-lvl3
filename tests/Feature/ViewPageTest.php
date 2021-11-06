<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\CreatesApplication;
use Tests\TestCase;

use function route;

class ViewPageTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testViewPage(): void
    {
        $domainName = "https://google.com";
        $id = DB::table('urls')->insertGetId([
            'name' => $domainName,
            'created_at' => CarbonImmutable::now(),
        ]);
        $response = $this
            ->post(route('urls.store'), ['url' => ['name' => $domainName]])
            ->assertRedirect(route('urls.show', ['id' => $id]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('urls', 1);
    }
}
