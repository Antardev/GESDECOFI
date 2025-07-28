<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureCN
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user() && (Str::contains(auth()->user()->validated_type, 'CN') || Str::contains(auth()->user()->validated_type, 'assistant_controller'))) {

            if(Str::contains(auth()->user()->validated_type, 'assistant_controller'))
            {
                if(!get_assistant()->activated)
                {
                    return redirect()->route('accueil')
                        ->with('access_denied', __('message.access_denied'));                    
                }

            }
            return $next($request);

        } else {

            return redirect()->route('accueil')
                ->with('access_denied', __('message.access_denied'));
        }

        return $next($request);
    }
}
