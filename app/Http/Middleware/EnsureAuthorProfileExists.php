<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthorProfileExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Dapatkan user yang sedang login
        $user = auth()->user();

        // Cek apakah user memiliki authorProfile
        if (!$user || !$user->authorProfile) {
            return redirect()->route('authors.create')->with('error', 'Anda harus membuat profil penulis terlebih dahulu.');
        }

        return $next($request);
    }
}
