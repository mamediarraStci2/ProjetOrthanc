<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Si le rôle est au format "role:admin", extraire "admin"
        if (strpos($role, ':') !== false) {
            $role = explode(':', $role)[1];
        }
        
        Log::info('Vérification du rôle', [
            'user' => $request->user() ? $request->user()->id : 'non connecté',
            'role_requis' => $role,
            'role_utilisateur' => $request->user() ? $request->user()->role : 'non connecté'
        ]);
        
        if (!$request->user() || !$request->user()->hasRole($role)) {
            Log::warning('Accès refusé', [
                'user' => $request->user() ? $request->user()->id : 'non connecté',
                'role_requis' => $role,
                'role_utilisateur' => $request->user() ? $request->user()->role : 'non connecté'
            ]);
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
} 