<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['username', 'fullname', 'password', 'address', 'level', 'foto'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_user';

    protected $primaryKey = 'userid';

    public $incrementing = true;

    public $timestamps = false;

    protected $casts = [
        'level' => 'integer',
    ];

    public function isAdmin(): bool
    {
        return $this->level == 1;
    }

    public function isSupervisor(): bool
    {
        return $this->level == 2;
    }

    public function isOperator(): bool
    {
        return $this->level == 3;
    }

    public function levelName(): string
    {
        return match ($this->level) {
            1 => 'Administrator',
            2 => 'Supervisor',
            3 => 'Operator',
            default => 'Unknown',
        };
    }
}
