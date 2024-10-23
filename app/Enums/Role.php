<?php

namespace App\Enums;

enum Role
{
    case ADMIN;
    case SISWA;

    public function status(): string
    {
        return match ($this) {
            self::ADMIN => 'admin',
            self::SISWA => 'siswa',
        };
    }
}