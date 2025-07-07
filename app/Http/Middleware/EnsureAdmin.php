<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user() && Str::contains(auth()->user()->validated_type, 'admin') && auth()->user()->email =='decofiadmin@decofi.com') {

            return $next($request);

        } else {
            return redirect()->route('accueil')
                ->with('access_denied', __('message.access_denied'));
        }

        return $next($request);
    }
}
