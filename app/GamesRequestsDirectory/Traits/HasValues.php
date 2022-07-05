<?php

namespace App\GamesRequestsDirectory\Traits;

trait HasValues
{
    public static function values(): array
    {
        return array_map(
            fn(self $enum) => $enum->value,
            self::cases()
        );
    }
}
