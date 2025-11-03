<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        
        // Cek apakah role user sesuai dengan role yang diharapkan
        if ($user->role !== $role) {
            // Log untuk debugging (opsional, bisa dihapus di production)
            \Log::warning('403 Access Denied', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'required_role' => $role,
                'route' => $request->path()
            ]);
            
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
