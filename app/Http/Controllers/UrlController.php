<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UrlController extends Controller
{
    public function check(Request $request): void
    {
        Url::create(['name' => $request->url['name']]);
    }
}
