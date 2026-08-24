<?php

namespace App\Nova;

use App\Enums\VaultAccessLevel;
use App\Enums\VaultCategory;
use App\Enums\VaultFileType;
use App\Nova\Filters\VaultAccessLevelFilter;
use App\Nova\Filters\VaultCategoryFilter;
use App\Nova\Filters\VaultFileTypeFilter;
use App\Services\Vault\VaultAssetFileService;
use Illuminate\Validation\Validator;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\MultiselectField\Multiselect;

class VaultAsset extends Resource
{
    public const FILE_SOURCE_UPLOAD = 'upload';

    public const FILE_SOURCE_URL = 'url';

    public static $model = \App\Models\VaultAsset::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'title',
        'sub_category',
        'group_name',
        'file_url',
    ];

    public static function label()
    {
        return 'Vault Assets';
    }

    public static function singularLabel()
    {
        return 'Vault Asset';
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')->sortable()->rules('required', 'max:255'),

            Heading::make('File')->hideFromIndex()->hideFromDetail(),

            Select::make('File Source', 'file_source')
                ->options([
                    self::FILE_SOURCE_UPLOAD => 'Upload a file',
                    self::FILE_SOURCE_URL => 'Use a file URL',
                ])
                ->displayUsingLabels()
                ->nullable()
                ->placeholder('Choose one')
                ->rules('required')
                ->help('Pick one option. Only that field will appear.')
                ->onlyOnForms()
                ->resolveUsing(function () {
                    if (!$this->resource->exists) {
                        return null;
                    }

                    return filled($this->resource->file_path)
                        ? self::FILE_SOURCE_UPLOAD
                        : self::FILE_SOURCE_URL;
                })
                ->fillUsing(function () {
                    // Form-only. The chosen option decides which field below is saved.
                }),

            File::make('Upload File', 'file_path')
                ->disk(config('vault.upload_disk', 'public'))
                ->acceptedTypes('.pdf,.ppt,.pptx,.xls,.xlsx,.doc,.docx,.zip,.png,.jpg,.jpeg,.gif,.webp,.svg')
                ->rules('nullable', 'file', 'max:102400')
                ->store(function (NovaRequest $request, $model, $attribute, $requestAttribute) {
                    $file = $request->file($requestAttribute);
                    if ($file === null || $request->input('file_source') !== self::FILE_SOURCE_UPLOAD) {
                        return [];
                    }

                    return app(VaultAssetFileService::class)->storeUpload($file, $model);
                })
                ->prunable()
                ->deletable()
                ->help('PDF, slide deck, spreadsheet, ZIP, or image (max 100MB).')
                ->hideFromIndex()
                ->dependsOn(['file_source'], function (File $field, NovaRequest $request, FormData $formData) {
                    if ($formData->file_source === self::FILE_SOURCE_UPLOAD) {
                        $field->show();
                    } else {
                        $field->hide();
                    }
                }),

            Text::make('File URL', 'file_url')
                ->nullable()
                ->rules('nullable', 'max:2048')
                ->help('Paste an existing WordPress, Dropbox, or Hostinger link.')
                ->hideFromIndex()
                ->dependsOn(['file_source'], function (Text $field, NovaRequest $request, FormData $formData) {
                    if ($formData->file_source === self::FILE_SOURCE_URL) {
                        $field->show();
                    } else {
                        $field->hide();
                    }
                })
                ->fillUsing(function (NovaRequest $request, $model, $attribute, $requestAttribute) {
                    if ($request->input('file_source') !== self::FILE_SOURCE_URL) {
                        return;
                    }

                    $url = trim((string) $request->input($requestAttribute, ''));
                    if ($url === '') {
                        return;
                    }

                    app(VaultAssetFileService::class)->useExternalUrl($model, $url);
                }),

            Text::make('Image URL', 'image_url')
                ->nullable()
                ->hideFromIndex(),

            Select::make('Category')
                ->options($this->enumOptions(VaultCategory::class))
                ->displayUsingLabels()
                ->sortable()
                ->rules('required')
                ->resolveUsing(fn ($value) => $value instanceof \BackedEnum ? $value->value : $value),

            Text::make('Sub-category', 'sub_category')->nullable()->sortable(),

            Text::make('Group', 'group_name')->nullable()->hideFromIndex(),

            Select::make('File Type', 'file_type')
                ->options($this->enumOptions(VaultFileType::class))
                ->displayUsingLabels()
                ->sortable()
                ->nullable()
                ->rules('nullable')
                ->help('Leave blank to detect from the upload or File URL.')
                ->resolveUsing(fn ($value) => $value instanceof \BackedEnum ? $value->value : $value),

            Date::make('Date', 'published_at')->nullable()->sortable(),

            Multiselect::make('Tags')
                ->options(fn () => $this->tagOptions())
                ->taggable()
                ->reorderable()
                ->nullable()
                ->saveAsJSON()
                ->placeholder('Type a tag and press Enter')
                ->help('Type a keyword and press Enter to add a chip. Press Enter again for the next tag. Click a chip to remove it.')
                ->hideFromIndex(),

            Select::make('Access Level', 'access_level')
                ->options($this->enumOptions(VaultAccessLevel::class))
                ->displayUsingLabels()
                ->rules('required')
                ->resolveUsing(fn ($value) => $value instanceof \BackedEnum ? $value->value : $value),

            Text::make('Pricing Key', 'pricing_key')
                ->nullable()
                ->help('Must match a price-list title (Americas, International, Dealer Price List, Retail Price List).')
                ->hideFromIndex(),

            Boolean::make('Frequently Used', 'is_frequently_used')->sortable(),
            Boolean::make('Newly Added', 'is_newly_added')->sortable(),
            Boolean::make('Tour Starter', 'is_tour_starter')->hideFromIndex(),
            Boolean::make('Active', 'is_active')->sortable(),

            Number::make('Sort Order', 'sort_order')->min(0)->step(1)->hideFromIndex(),
        ];
    }

    /**
     * Exactly one source: upload a file, or paste a URL.
     */
    protected static function afterValidation(NovaRequest $request, $validator)
    {
        $source = $request->input('file_source');

        /** @var Validator $validator */
        if ($source === self::FILE_SOURCE_UPLOAD) {
            if ($request->hasFile('file_path')) {
                return;
            }

            if ($request->isUpdateOrUpdateAttachedRequest()) {
                $existing = static::$model::query()->find($request->resourceId);
                if ($existing && filled($existing->file_path)) {
                    return;
                }
            }

            $validator->errors()->add('file_path', 'Upload a file, or switch to Use a file URL.');

            return;
        }

        if ($source === self::FILE_SOURCE_URL) {
            if (filled($request->input('file_url'))) {
                return;
            }

            $validator->errors()->add('file_url', 'Paste a File URL, or switch to Upload a file.');
        }
    }

    /**
     * @param  class-string<\BackedEnum>  $enum
     * @return array<string, string>
     */
    private function enumOptions(string $enum): array
    {
        $options = [];
        foreach ($enum::cases() as $case) {
            $options[$case->value] = method_exists($case, 'label') ? $case->label() : $case->name;
        }

        return $options;
    }

    /**
     * Existing catalog tags plus this asset's tags, so chips round-trip on edit.
     *
     * @return array<string, string>
     */
    private function tagOptions(): array
    {
        $options = \App\Models\VaultAsset::tagOptions();

        foreach ($this->resource->tagList() as $tag) {
            $options[$tag] = $tag;
        }

        return $options;
    }

    public function filters(NovaRequest $request)
    {
        return [
            new VaultCategoryFilter(),
            new VaultFileTypeFilter(),
            new VaultAccessLevelFilter(),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}
