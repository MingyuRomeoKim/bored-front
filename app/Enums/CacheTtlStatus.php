<?php

namespace App\Enums;

enum CacheTtlStatus: int
{
    case SHORT = 60;
    case MEDIUM = 300;
    case LONG = 600;
    case VERY_LONG = 3600;

    public static function getTtl(CacheTtlStatus $status): int
    {
        return match ($status) {
            self::SHORT => self::SHORT->value,
            self::MEDIUM => self::MEDIUM->value,
            self::LONG => self::LONG->value,
            self::VERY_LONG => self::VERY_LONG->value,
            default => self::MEDIUM->value,
        };
    }
}
