<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    public function check(Request $request)
    {
        Url::create(['name' => $request->url['name']]);

        dd($request->url['name']);
    }
}
