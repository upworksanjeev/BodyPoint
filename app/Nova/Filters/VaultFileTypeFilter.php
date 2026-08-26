<?php

namespace App\Nova\Filters;

use App\Enums\VaultFileType;

class VaultFileTypeFilter extends VaultEnumFilter
{
    public $name = 'File Type';

    protected string $enumClass = VaultFileType::class;

    protected string $column = 'file_type';
}
