<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Command
{
    protected $signature = 'pos:reset-password
                            {username : The username to reset}
                            {password : The new password (min. 4 characters)}';

    protected $description = 'Reset the password of a WebPOS user';

    public function handle(): int
    {
        $username = (string) $this->argument('username');
        $password = (string) $this->argument('password');

        if (strlen($password) < 4) {
            $this->error('Password must be at least 4 characters long.');

            return self::FAILURE;
        }

        $user = User::where('username', $username)->first();

        if (! $user) {
            $this->error("User '{$username}' was not found.");

            return self::FAILURE;
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        $this->info("Password for '{$username}' ({$user->fullname}) has been reset.");

        return self::SUCCESS;
    }
}
