<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NeutronHeaders
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
        $response = $next($request);
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        $response->header('X-Xss-Protection', '1; mode=block');
        $response->header('Set-Cookie', 'httponly');
        $response->header('Cache-Control', 'no-cache');
        $response->header('Content-Security-Policy', "default-src 'self'; script-src 'self' https://code.jquery.com/  'unsafe-inline' 'unsafe-eval'; style-src 'self' https://fonts.googleapis.com https://cdnjs.cloudflare.com/ 'unsafe-inline'; font-src 'self' *;connect-src 'self' ws://127.0.0.1:6001 wss://tmsstoreonly.com:6001 ws://tmsstoreonly.com:6001 ws://ctl.tmsstoreonly.com:6001 wss://ctl.tmsstoreonly.com:6001 https://dym-file.s3.ap-southeast-1.amazonaws.com;img-src 'self' https://dym-file.s3.ap-southeast-1.amazonaws.com;");

        return $response;

    }
}
