<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user() && Str::contains(auth()->user()->validated_type, 'superadmin') && auth()->user()->email =='decofisuperadmin@decofi.com') {

            return $next($request);

        } else {
            return redirect()->route('accueil')
                ->with('access_denied', __('message.access_denied'));
        }

        return $next($request);
    }
}
