<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->hasVerifiedEmail()) {

            return $next($request);

        } else {
            return redirect()->route('verification.notice')
                ->with('warning', __('message.verify_your_email'));
        }

        return $next($request);
    }
}
