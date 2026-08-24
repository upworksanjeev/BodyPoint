<?php

namespace App\Nova\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class VaultEnumFilter extends Filter
{
    /**
     * @var class-string<\BackedEnum>
     */
    protected string $enumClass;

    protected string $column;

    public $component = 'select-filter';

    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where($this->column, $value);
    }

    public function options(NovaRequest $request): array
    {
        $options = [];
        foreach ($this->enumClass::cases() as $case) {
            $label = method_exists($case, 'label') ? $case->label() : $case->name;
            $options[$label] = $case->value;
        }

        return $options;
    }
}
