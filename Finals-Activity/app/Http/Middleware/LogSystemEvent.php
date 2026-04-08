<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\EventLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogSystemEvent
{
    /**
     * Log each incoming request and the response status code.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            EventLog::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'event_type' => 'request',
                'description' => sprintf('%s %s', $request->method(), $request->path()),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'path' => $request->path(),
                'method' => $request->method(),
                'status_code' => $response->getStatusCode(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to write event log: '.$e->getMessage());
        }

        return $response;
    }
}