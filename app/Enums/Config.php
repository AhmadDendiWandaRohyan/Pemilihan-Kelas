<?php

namespace App\Enums;

enum Config
{
    case DEFAULT_PASSWORD;
    case PAGE_SIZE;

    public function value(): string
    {
        return match ($this) {
            self::DEFAULT_PASSWORD => 'default_password',
            self::PAGE_SIZE => 'page_size',
        };
    }
}