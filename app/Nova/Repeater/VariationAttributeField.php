<?php

namespace App\Nova\Repeater;

use Laravel\Nova\Fields\Repeater\Repeatable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\FormData;

class VariationAttributeField extends Repeatable
{
    /**
     * Get the fields displayed by the repeatable.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
			//ID::make(),
			/*Select::make('Attribute','product_attribute_id')->options(\App\Models\Attribute::leftJoin('product_attributes', 'attributes.id', '=', 'product_attributes.attr_id')->where('product_attributes.prod_id', $request->viaResourceId)->pluck('attributes.attribute', 'product_attributes.id'))->hideFromIndex()->hideFromDetail()->fillUsing(function(NovaRequest $request, $model, $attribute, $requestAttribute) {
                return null;
            }),*/
			Select::make('Attribute','product_attribute_id')->options(\App\Models\Attribute::leftJoin('product_attributes', 'attributes.id', '=', 'product_attributes.attr_id')->leftJoin('variations', 'variations.product_id', '=', 'product_attributes.prod_id')->where('variations.id', $request->viaResourceId)->pluck('attributes.attribute', 'product_attributes.id'))->hideFromIndex()->hideFromDetail()->fillUsing(function(NovaRequest $request, $model, $attribute, $requestAttribute) {
                return null;
            }),
        ];
    }
}
