<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected $supported_languages = ['ar', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->has('locale')) {
            session(['locale' => $request->getPreferredLanguage($this->supported_languages)]);
        }
        app()->setLocale(session('locale'));
        Carbon::setLocale(session('locale'));

        if (session('locale') == 'ar') {
            setDirection('rtl');
        } elseif (session('locale') == 'en') {
            setDirection('ltr');
        }
        // dd(getDirection());


        return $next($request);
    }
}
