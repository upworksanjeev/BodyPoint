<?php

namespace App\Nova\Filters;

use App\Enums\VaultCategory;

class VaultCategoryFilter extends VaultEnumFilter
{
    public $name = 'Category';

    protected string $enumClass = VaultCategory::class;

    protected string $column = 'category';
}
