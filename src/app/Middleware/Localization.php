<?php

namespace sOne\Core\app\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $string = $_SERVER['REQUEST_URI'];
        $find   = config('sone::core.prefix');

        $pos = strpos($string, $find);

        if($pos === 1) {
            if (session()->has('locale')) {
                App::setLocale(session()->get('locale'));
            }
        }
        return $next($request);
    }
}
