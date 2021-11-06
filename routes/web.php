<?php

use Carbon\CarbonImmutable;
use DiDom\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
})->name('home.index');

Route::post('/urls', function (Request $request): RedirectResponse {
    $domaneName = $request->url;
    $validated = validator($domaneName, [
        'name' => ['required', 'string', 'max:255', 'url']
    ])->validate();
    $parsedUrl = parse_url($validated['name']);
    $host = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
    $url = DB::table('urls')->where('name', $host)->first();
    if (!is_null($url)) {
        flash('Сайт существует')->success();
        return redirect(route('urls.show', ['id' => $url->id]));
    }
    $id = DB::table('urls')->insertGetId([
        'name' => $host,
        'created_at' => CarbonImmutable::now(),
    ]);
    flash('Сайт добавлен')->success();
    return redirect(route('urls.show', ['id' => $id]));
})->name('urls.store');

Route::get('/urls', function (): View {
    $Domains = DB::table('urls')
        ->get();
    return view('urls', ['domains' => $Domains]);
})->name('urls.index');

Route::get('/urls/{id}', function (Request $request) {
    $id = (int)$request->route('id');
    if (is_null(DB::table('urls')->find($id))) {
        return response('Такого адреса не существует', 404);
    }
    $checks = DB::table('url_checks')->where('url_id', $id)->get();
    $domain = DB::table('urls')
        ->find($id);
    return view('url', ['domain' => $domain, 'checks' => $checks]);
})->name('urls.show');

Route::post('urls/{id}/checks', function (Request $request): RedirectResponse {
    $urlId = (int)$request->route('id');
    $url = DB::table('urls')->find($urlId);
    $domain = $url->name;
    $domainResponse = Http::get($domain);
    $status = $domainResponse->status();
    $response_body = $domainResponse->body();
    $document = new Document($response_body);
    $getH1 = optional($document->first('h1'))->text();
    $h1 = is_null($getH1) ? 'h1 not found' : $getH1;
    $getTitle = optional($document->first('title'))->text();
    $title = is_null($getTitle) ? 'title not found' : $getTitle;
    $getDescription = optional($document->first('meta[name=description]'))->attr('content');
    $description = is_null($getDescription) ? 'description not found' : $getDescription;
    DB::table('url_checks')->insertGetId([
        'url_id' => $urlId,
        'status_code' => $status,
        'h1' => $h1,
        'title' => $title,
        'description' => $description,
        'created_at' => CarbonImmutable::now(),
    ]);
    flash('Страница успешно проверенна!')->success();
    return redirect()->route('urls.show', ['id' => $urlId]);
})->name('checks.store');
