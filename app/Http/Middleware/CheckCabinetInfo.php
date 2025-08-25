<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Stagiaire;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckCabinetInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et est un stagiaire
        if (Auth::check() && Auth::user()->user_type === 'stagiaire') {
            $stagiaire = Stagiaire::where('user_id', Auth::id())->first();
            
            if ($stagiaire && $this->requiresCabinetInfo($stagiaire)) {
                // Vérifier si l'utilisateur essaie d'accéder à une route exemptée
                if (!$request->is('stagiaire/cabinet-info*') && 
                    !$request->is('logout') &&
                    !$request->is('stagiaire/profile') &&
                    !$request->is('stagiaire/update-cabinet-info')) {
                    
                    return redirect()->route('stagiaire.cabinet-info')
                        ->with('warning', 'Veuillez compléter vos informations de cabinet pour la 2ème année avant de continuer.');
                }
            }
        }

        return $next($request);
    }

    private function requiresCabinetInfo($stagiaire)
    {
        // Vérifier si le stagiaire est en entreprise et a commencé le 2ème semestre
        if ($stagiaire->structure_type !== 'entreprise') {
            return false;
        }

        // Vérifier si le 2ème semestre a commencé
        $secondSemesterStart = Carbon::parse($stagiaire->semester_2_begin);
        
        if (now()->lt($secondSemesterStart)) {
            return false;
        }

        // Vérifier si les informations de cabinet sont déjà complétées
        return empty($stagiaire->cabinet_submitted_at);
    }
}
