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
use Laravel\Nova\Fields\MultiSelect;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Trix;


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
    public static $title = 'id';

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
				
			Text::make('Tagline','small_description')->maxlength(255)->hideFromIndex(),
			Text::make('Tagline','small_description')->displayUsing(function($id) {
				$part = strip_tags(substr($id, 0, 20));
				return $part . "...";
				})->onlyOnIndex(),
				
			Trix::make('Description','description')->hideFromIndex()->alwaysShow(),
			Trix::make('Sizing','sizing')->hideFromIndex()->alwaysShow(),
			Trix::make('Instruction of use','instruction_of_use')->hideFromIndex()->alwaysShow(),
			Trix::make('Warranty','warranty')->hideFromIndex()->alwaysShow(),
	
			Select::make('Product Type')->options([
				'Single' => 'Single',
				'Option' => 'Option',
			]),
			/*Image::make('Category Image','image')->disk('public')->disableDownload(),*/
			//BelongsTo::make('Category', 'cat_id', \App\Nova\Product::class)->showOnIndex()->sortable()->hideWhenCreating()->hideWhenUpdating(),
			/*HasMany::make('Category'),
			MultiSelect::make('Category','cat_id')->options(\App\Models\Category::pluck('name', 'id'))->hideFromIndex()->hideFromDetail(),*/
			
        ];
    }

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
