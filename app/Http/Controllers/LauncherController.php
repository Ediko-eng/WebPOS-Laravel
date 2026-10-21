<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SessionSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LauncherController extends Controller
{
    /**
     * The entry point of the application.
     *
     * Without a session slot this page lists the three sessions that can be
     * opened side by side (each one keeps its own login). With a slot it
     * simply hands over to the normal dashboard.
     */
    public function index(Request $request)
    {
        $slot = SessionSlot::current($request);

        if ($slot !== null) {
            return redirect()->route('dashboard');
        }

        return view('launcher', [
            'slots' => $this->slots(),
            'basePath' => $this->basePath($request),
            'currentUser' => Auth::check() ? Auth::user() : null,
        ]);
    }

    /**
     * The three session slots and the account each one is meant for.
     */
    protected function slots(): Collection
    {
        $users = User::orderBy('level')->get();

        $slots = [];

        for ($slot = 1; $slot <= SessionSlot::SLOTS; $slot++) {
            $user = $users->get($slot - 1);

            $slots[] = [
                'number' => $slot,
                'username' => $user?->username,
                'fullname' => $user?->fullname,
                'level' => $user?->level,
                'levelName' => $user ? $this->levelName($user->level) : null,
            ];
        }

        return collect($slots);
    }

    /**
     * The path the application is installed in, e.g. /WebPOS-Laravel
     */
    protected function basePath(Request $request): string
    {
        $script = $request->server->get('SCRIPT_NAME', '/index.php');

        return rtrim(str_replace('\\', '/', dirname($script)), '/');
    }

    /**
     * Human readable level name.
     */
    protected function levelName(int $level): string
    {
        return match ($level) {
            1 => 'Administrator',
            2 => 'Supervisor',
            3 => 'Operator',
            default => 'Operador',
        };
    }
}
