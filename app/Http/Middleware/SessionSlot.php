<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

/**
 * Multi-session support.
 *
 * The application can be opened under a "session slot" path, e.g.
 *
 *     /WebPOS-Laravel/s1/login
 *     /WebPOS-Laravel/s2/login
 *     /WebPOS-Laravel/s3/login
 *
 * Every slot gets its own session cookie (unique name) scoped to its own
 * path, so a single browser can hold three different users logged in at
 * the same time. Without this the browser would only ever send one
 * session cookie and the last login would win.
 *
 * The slot prefix is also used as the request base URL, so every URL the
 * application generates keeps the prefix and the browser sends the right
 * cookie back.
 */
class SessionSlot
{
    /** Number of available session slots. */
    public const SLOTS = 3;

    public function handle(Request $request, Closure $next): Response
    {
        $slot = $this->detectSlot($request);

        if ($slot !== null) {
            $prefix = $this->prefix($request, $slot);

            // Give this slot its own session cookie, scoped to the slot
            // path so the browser keeps the three sessions apart.
            Config::set('session.cookie', $this->cookieName($slot));
            Config::set('session.path', $prefix);

            // Point SCRIPT_NAME inside the slot so Symfony derives the base
            // URL (and therefore the path info) from it. This keeps every
            // generated URL inside the slot.
            $scriptName = $request->server->get('SCRIPT_NAME', '/index.php');
            $request->server->set('SCRIPT_NAME', $prefix.'/'.basename($scriptName));

            $request->attributes->set('pos_slot', $slot);
            $request->attributes->set('pos_slot_prefix', $prefix);
        }

        return $next($request);
    }

    /**
     * Find the slot number in the request path, if any.
     */
    protected function detectSlot(Request $request): ?int
    {
        $path = parse_url($request->server->get('REQUEST_URI', '/'), PHP_URL_PATH) ?: '/';

        if (preg_match('#^(/.+)/s([1-9][0-9]*)(/.*)?$#', $path, $matches)) {
            $slot = (int) $matches[2];

            return $slot <= self::SLOTS ? $slot : null;
        }

        return null;
    }

    /**
     * The path prefix of a slot, e.g. /WebPOS-Laravel/s1
     */
    protected function prefix(Request $request, int $slot): string
    {
        $path = parse_url($request->server->get('REQUEST_URI', '/'), PHP_URL_PATH) ?: '/';

        preg_match('#^(/.+)/s[1-9][0-9]*(?:/.*)?$#', $path, $matches);

        $base = $matches[1] ?? '';

        return $base.'/s'.$slot;
    }

    /**
     * The session cookie name used by a slot.
     */
    public function cookieName(int $slot): string
    {
        return 'si-pos-kasir-session-s'.$slot;
    }

    /**
     * The slot the current request belongs to, if any.
     */
    public static function current(Request $request): ?int
    {
        $slot = $request->attributes->get('pos_slot');

        return $slot === null ? null : (int) $slot;
    }
}
