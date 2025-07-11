<?php

namespace App\Http\Middleware;

use App\Models\ControleurAssistant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class EnsureInformationsCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user() && (Str::contains(auth()->user()->validated_type, 'assistant_controller'))) {
            $assistant = ControleurAssistant::where('user_id', auth()->id())->first();

            if(!$assistant->picture_path)
            {
                
                return redirect()->route('assistant.complete');

            } else {
                return $next($request);
            }

        }

        return $next($request);
    }
}
