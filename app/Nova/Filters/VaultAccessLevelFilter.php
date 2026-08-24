<?php

namespace App\Nova\Filters;

use App\Enums\VaultAccessLevel;

class VaultAccessLevelFilter extends VaultEnumFilter
{
    public $name = 'Access Level';

    protected string $enumClass = VaultAccessLevel::class;

    protected string $column = 'access_level';
}
