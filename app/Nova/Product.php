<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\MorphToMany;
use App\Models\Category;
use Outl1ne\MultiselectField\Multiselect;


class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {

        return [
            ID::make()->sortable(),
			Text::make('Name','name')->sortable()->required(true)->rules('required', 'max:255'),
            Multiselect::make('Categories', 'categories')->belongsToMany(\App\Nova\Category::class, false),
			Text::make('Tagline','small_description')->maxlength(255)->hideFromIndex(),
			Text::make('Tagline','small_description')->displayUsing(function($id) {
				$part = strip_tags(substr($id, 0, 20));
				return $part . "...";
				})->onlyOnIndex(),

			Trix::make('Description','description')->hideFromIndex()->alwaysShow(),
			Trix::make('Sizing','sizing')->hideFromIndex()->alwaysShow(),
			Trix::make('Instruction of use','instruction_of_use')->hideFromIndex()->alwaysShow(),
			Trix::make('Warranty','warranty')->hideFromIndex()->alwaysShow(),

			Select::make('Product Type','product_type')->options([
				'Single' => 'Single',
				'Option' => 'Option',
			]),

            HasMany::make('Attribute','attribute',\App\Nova\ProductAttribute::class)->hideFromIndex(),
        ];
    }

	/**
     * Register a callback to be called after the resource is created.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
/*	 public static function afterCreate(NovaRequest $request, Model $model)
    {
        //$model->sendEmailVerificationNotification();
    }*/

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
