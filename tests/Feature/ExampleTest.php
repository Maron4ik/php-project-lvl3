<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\CreatesApplication;

class ExampleTest extends TestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMainPath(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function testUrlsPath(): void
    {
        $response = $this->get('/urls');
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function testIdPath(): void
    {
        $response = $this->get('/urls/22');
        $response->assertStatus(404);
        $response->assertSessionHasNoErrors();
    }

    public function testIdPathForbidden(): void
    {
        $response = $this->get('/urls/fight');
        $response->assertStatus(404);
        $response->assertSessionHasNoErrors();
    }

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
    public function testViewPage(): void
    {
        $domainName = "https://google.com";
        $id = DB::table('urls')->insertGetId([
            'name' => $domainName,
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now()
        ]);

        $response = $this
            ->post('/urls', ['url' => ['name' => $domainName]])
            ->assertRedirect(route('urls.show', ['id' => $id]));
        $response->assertSessionHasNoErrors();

//        $response->assertSeeText($domainName);
        $this->assertDatabaseCount('urls', 1);
    }
/**task
 * 1. Проверить что создается запись в БД urls_checks при отправке POST
 * 2. Проверить что на странице urls/{id} создана запись
 */
    public function testCreateCheck(): void
    {
        $domainName = "https://google.com";
        $id = DB::table('urls')->insertGetId([
            'name' => $domainName,
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now()
        ]);

        /**task
         * 1. Создали заглушку что при HTTP запросе вернется заранее прописанные данные
         */
        $testHtml = file_get_contents(__DIR__ . '/../fixtures/test.html');
//        Http::fake([
//            $this->url => Http::response($testHtml, 200)
//        ]);
        Http::fake(function ($request) use ($testHtml) {
            return Http::response($testHtml, 200);
        });

        /**task
         * 1. followingRedirects - разрешает тесту пользоваться редиректами
         * 2. Делает пост запрос по роуту checks.store с передачей требуемых данных
         * 3. обработчик должен делать запрос во вне, но из-за заглушки он получает наши фейковые данные
         * 4. создает результат проверки url и сохраняет в БД
         */
        $response = $this
            ->followingRedirects()
            ->post(route('checks.store', ['id' => $id]))->assertStatus(200);
        $response->assertSessionHasNoErrors();
        /**task добавить flash сообщения
         * добавить под каждым запросом $response->assertSessionHasNoErrors();
         */
//        $response->assertSessionHasNoErrors();
        /**task
         * 1. добавить данные
         */
        $this->assertDatabaseHas('url_checks', [
            'status_code' => 200,
            'h1' => 'test h1', //TODO
            'title' => 'one, two, three',  //TODO
            'description' => 'test description',  //TODO
        ]);
    }

    public function testViewPageOnCheck(): void
    {
        $domainName = "https://google.com";
        $id = DB::table('urls')->insertGetId([
            'name' => $domainName,
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now()
        ]);
        $checks = DB::table('url_checks')->insertGetId([
            'url_id' => $id,
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now()
        ]);
        $response = $this
            ->get('urls/1', ['url' => ['name' => $domainName]]);
        $response->assertSeeText('1')->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }
}
