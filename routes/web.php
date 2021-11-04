<?php

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/', function (Request $request, Response $response) {
    $name = $request->url;

    $validated = validator($name, [
        'name' => ['required', 'string', 'max:255', 'url']
    ])->validate();

    $parsedUrl = parse_url($validated['name']);

    $host = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
    $url = DB::table('urls')->where('name', $host)->first();

    if ($url) {
        $id = $url->id;
        flash('Сайт существует')->success();
        return redirect('urls/' . $id);
    }

    $id = DB::table('urls')->insertGetId([
        'name' => $host,
        'created_at' => CarbonImmutable::now(),
        'updated_at' => CarbonImmutable::now()
    ]);
    flash('Сайт добавлен')->success();
    return redirect(route('url.show', ['id' => $id]));
})->name('url');



Route::get('/urls', function (Request $request, Response $response) {
    $names = DB::table('urls')
        ->get();
    return view('urls', ['names' => $names]);
})->name('urls');

Route::get('/urls/{id}', function (Request $request, Response $response) {
    route('url.show', ['id' => 2, 'page' => 1]);
    $id = $request->route('id');
    if (!DB::table('urls')->find($id)) {

        return response('Такого адреса не существует', 404)
            ->header('Content-Type', 'text/plain');
    }
//guard expression
    $checks = DB::table('urls_checks')
        ->where('urls_id', '=', $id)
        ->get();

    $name = DB::table('urls')
        ->where('id', '=', $id)
        ->get();
    return view('url', ['name' => $name[0], 'checks' => $checks]);

})->name('url.show');


Route::post('urls/{id}/checks', function (Request $request) {

    $urlId = $request->route('id');
//    $url = DB::table('urls')->where('id', $urlsId)->first();
    $url = DB::table('urls')->find($urlId);
    $domain = $url->name;
    $status = Http::get($domain)->status();

    $id2 = DB::table('urls_checks')->insertGetId([
        'urls_id' => $urlId,
        'status_code' => $status,
        'created_at' => CarbonImmutable::now(),
        'updated_at' => CarbonImmutable::now(),
    ]);
    flash('Страница успешно проверенна!')->success();
    return redirect()->route('url.show', ['id' => $urlId]);
})->name('url.checks');


//Route::fallback(function () {
//    return view('welcome');
//});
