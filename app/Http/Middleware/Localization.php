<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = 'en';
        if ($request->hasHeader('Accept-Language')) {
            if ($request->header('Accept-Language') == 'Kiswahili' || $request->header('Accept-Language') == 'Swahili') {
                $locale = 'sw';
            }
            if ($request->header('Accept-Language') == 'Kingereza' || $request->header('Accept-Language') == 'English') {
                $locale = 'en';
            }
        }
        // $locale = ($request->hasHeader('Accept-Language'))? $request->header('Accept-Language') : 'en';
        app()->setLocale($locale);
        return $next($request);
    }
}
