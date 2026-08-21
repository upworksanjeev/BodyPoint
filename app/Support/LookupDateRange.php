<?php

namespace App\Support;

use Carbon\Carbon;

class LookupDateRange
{
    public static function parseStart(?string $input, ?Carbon $minimum = null): ?Carbon
    {
        if ($input === null || trim($input) === '') {
            return $minimum;
        }

        $parsed = Carbon::parse($input)->startOfDay();

        if ($minimum !== null && $parsed->lt($minimum)) {
            return $minimum->copy();
        }

        return $parsed;
    }

    public static function parseEnd(?string $input): ?Carbon
    {
        if ($input === null || trim($input) === '') {
            return null;
        }

        $parsed = Carbon::parse($input)->endOfDay();
        $today = now()->endOfDay();

        return $parsed->gt($today) ? $today : $parsed;
    }
}
