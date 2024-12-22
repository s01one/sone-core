<?php

namespace sOne\Core\app\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Template
{
    public function handle($request, Closure $next): mixed
    {
        // Set theme if exists
        /*if (Session::has('sone::core.view_namespace')) {
            Config::set('sone::core.view_namespace', Session::get('sone::core.view_namespace'));
        }

        // Set layout if exist in session — only for Tabler
        if (Session::get('sone::core.view_namespace') === 'sone::core.sadmin::') {
            Config::set('backpack.theme-tabler.layout', Session::get('backpack.theme-tabler.layout') ?? config('backpack.theme-tabler.layout'));
        }

        return $next($request);*/
    }
}
