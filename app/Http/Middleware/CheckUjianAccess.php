<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUjianAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $tryoutId = $request->route('id');
        
        // Panggil fungsi pengecekan di controller
        $access = (new \App\Http\Controllers\UjianController)->checkUserAccess($tryoutId);

        if ($access['status'] == 'locked') {
            return redirect()->route('ujian.persiapan', $tryoutId)
                            ->with('error', $access['message']);
        }

        return $next($request);
    }
}
