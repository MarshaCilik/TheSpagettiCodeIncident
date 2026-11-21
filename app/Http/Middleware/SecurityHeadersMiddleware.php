<?php

namespace App\Http\Middleware;

/**
 * SecurityHeadersMiddleware - OWASP ZAP Comprehensive Hardening
 * Pengembang : Marsha Hafiz Devara
 * NIM        : 252410102057
 */

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request and attach OWASP recommended security headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hilangkan header bocoran teknologi server
        @header_remove('X-Powered-By');

        $response = $next($request);

        // Anti Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Hapus X-Powered-By dari Symfony HeaderBag jika ada
        $response->headers->remove('X-Powered-By');

        // Strict & Comprehensive Content Security Policy (menutup alert ZAP)
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
               "img-src 'self' data: https:; " .
               "font-src 'self' https://fonts.gstatic.com; " .
               "connect-src 'self'; " .
               "media-src 'self'; " .
               "object-src 'none'; " .
               "child-src 'none'; " .
               "frame-src 'none'; " .
               "worker-src 'none'; " .
               "frame-ancestors 'self'; " .
               "form-action 'self'; " .
               "base-uri 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
