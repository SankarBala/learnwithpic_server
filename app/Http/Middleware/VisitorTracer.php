<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class VisitorTracer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $visitor = new Visitor();
        $visitor->user_id = auth()->id() ?? 0;
        $visitor->ip = $request->ip();
        $visitor->route = $request->path();
        $visitor->user_agent = $request->userAgent();
        $visitor->location = json_encode(Location::get('103.120.223.98'));
        $visitor->refferer = $request->headers->get('referer');
        $visitor->save();

        return $next($request);
    }
}
