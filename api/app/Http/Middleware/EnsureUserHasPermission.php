<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        if ($permission === 'organizer') {
            $eventId = $request->route('event_id');
            if (!$eventId) {
                abort(400, 'Evento não especificado');
            }
            $event = \App\Models\Event::where('uuid', $eventId)->first();
            if (!$event) {
                abort(404, 'Evento não encontrado');
            }
            if (!$request->user()->can('organizer', $event)) {
                abort(403);
            }
            return $next($request);
        }
        if (! $request->user()->can($permission))
        {
            abort(403);
        }
        return $next($request);
    }
}
