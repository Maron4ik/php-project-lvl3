<?php

use Carbon\CarbonImmutable;
use DiDom\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home.index');

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
})->name('urls.store');

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
    $checks = DB::table('url_checks')
        ->where('url_id', '=', $id)
        ->get();
    $name = DB::table('urls')
        ->where('id', '=', $id)
        ->get();
    return view('url', ['name' => $name[0], 'checks' => $checks]);
})->name('url.show');

Route::post('urls/{id}/checks', function (Request $request) {
    $urlId = $request->route('id');
    $url = DB::table('urls')->find($urlId);
    $domain = $url->name;
    $status = Http::get($domain)->status();
    $data = Http::get($domain);
    $response_body = $data->body();
    $document = new Document($response_body);
    $h1 = optional($document->first('h1'))->text();
    $title = optional($document->first('meta[name=keywords]'))->attr('content');
    $description = optional($document->first('meta[name=description]'))->attr('content');
    $id2 = DB::table('url_checks')->insertGetId([
        'url_id' => $urlId,
        'status_code' => $status,
        'h1' => $h1,
        'title' => $title,
        'description' => $description,
        'created_at' => CarbonImmutable::now(),
        'updated_at' => CarbonImmutable::now(),
    ]);
    flash('Страница успешно проверенна!')->success();
    return redirect()->route('url.show', ['id' => $urlId]);
})->name('checks.store');
