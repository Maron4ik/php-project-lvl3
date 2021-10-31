<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        'name' => ['required', 'string', 'max:255', 'unique:urls']
    ])->validate();

    DB::table('urls')->insert([
        'name' => $validated['name'],
        'created_at' => CarbonImmutable::now(),
        'updated_at' => CarbonImmutable::now()
    ]);
    return view('welcome');
})->name('home');

Route::get('/urls', function (Request $request, Response $response) {

    $names = DB::table('urls')->get();
    return view('urls', ['names' => $names]);
})->name('urls');

Route::get('/urls/{id}', function (Request $request, Response $response) {

    $id = $request->route('id');
    $name = DB::table('urls')->where('id', '=', $id)->get();
    return view('url', ['name' => $name[0]]);
})->name('url');
Route::fallback(function () {
    return view('welcome');
});
