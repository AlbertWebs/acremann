<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Filament\Support\FormComponents;
use App\Models\Property;
use App\Support\PlotInventoryGenerator;
use App\Support\PropertyFormData;
use App\Support\PropertyFormOptions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Property')
                    ->contained(false)
                    ->persistTabInQueryString()
                    ->extraAttributes(['class' => 'acremann-property-form'])
                    ->tabs([
                        Tab::make('Overview')
                            ->icon(Heroicon::OutlinedBuildingOffice2)
                            ->schema(static::overviewTab()),
                        Tab::make('Plots')
                            ->icon(Heroicon::OutlinedSquares2x2)
                            ->schema(static::plotsTab()),
                        Tab::make('Media')
                            ->icon(Heroicon::OutlinedPhoto)
                            ->schema(static::mediaTab()),
                        Tab::make('Content')
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->schema(static::contentTab()),
                        Tab::make('Buyer trust')
                            ->icon(Heroicon::OutlinedShieldCheck)
                            ->schema(static::trustTab()),
                        Tab::make('Extras')
                            ->icon(Heroicon::OutlinedSquaresPlus)
                            ->schema(static::extrasTab()),
                        Tab::make('Publish & SEO')
                            ->icon(Heroicon::OutlinedRocketLaunch)
                            ->schema(static::publishTab()),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @return array<int, mixed>
     */
    protected static function overviewTab(): array
    {
        return [
            Section::make('Property identity')
                ->description('Name and public URL for this listing.')
                ->schema([
                    TextInput::make('title')
                        ->label('Property name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->columnSpanFull(),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Public page: /properties/{slug}')
                        ->suffixAction(
                            Action::make('generateSlug')
                                ->icon(Heroicon::OutlinedArrowPath)
                                ->tooltip('Generate from title')
                                ->action(fn (Get $get, Set $set) => $set('slug', Str::slug((string) $get('title'))))
                        ),
                ])
                ->columns(2)
                ->columnSpanFull(),
            Section::make('Location')
                ->schema([
                    TextInput::make('location')
                        ->label('Area / estate')
                        ->placeholder('Nachu, Kikuyu')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Select::make('county')
                        ->options(PropertyFormOptions::counties())
                        ->searchable()
                        ->native(false)
                        ->placeholder('Select county'),
                    Select::make('category')
                        ->options(PropertyFormOptions::categories())
                        ->required()
                        ->default('residential')
                        ->native(false),
                    Select::make('listing_type')
                        ->label('Listing type')
                        ->options(PropertyFormOptions::listingTypes())
                        ->required()
                        ->default('sale')
                        ->native(false),
                    Select::make('title_type')
                        ->label('Title type')
                        ->options(PropertyFormOptions::titleTypes())
                        ->required()
                        ->default('freehold')
                        ->native(false),
                ])
                ->columns(2)
                ->columnSpanFull(),
            Section::make('Pricing & availability')
                ->schema([
                    TextInput::make('price_from')
                        ->label('Price from')
                        ->numeric()
                        ->prefix('KES')
                        ->placeholder('850000')
                        ->helperText('Numeric starting price. Leave empty if you only use a custom label.'),
                    TextInput::make('price_label')
                        ->label('Price display label')
                        ->placeholder('From KES 850,000')
                        ->helperText('Overrides the numeric price on the website when set.'),
                    TextInput::make('plot_size')
                        ->label('Typical plot size')
                        ->placeholder('50 x 100 ft')
                        ->maxLength(120),
                    Select::make('status')
                        ->label('Listing status')
                        ->options(PropertyFormOptions::listingStatuses())
                        ->required()
                        ->default('available')
                        ->native(false),
                    Select::make('project_status')
                        ->label('Project phase')
                        ->options(PropertyFormOptions::projectStatuses())
                        ->required()
                        ->default('selling')
                        ->native(false)
                        ->helperText('Set to “Sold out” to show a sold-out badge even before all plots are marked sold.'),
                ])
                ->columns(2)
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function plotsTab(): array
    {
        return [
            Section::make('Quick generate')
                ->description('Enter the total number of plots in the development, then how many are sold or reserved. Remaining plots are marked available automatically — e.g. 38 total with 35 sold creates 38 plots (A-01 to A-38), not 73.')
                ->icon(Heroicon::OutlinedSparkles)
                ->collapsed()
                ->schema([
                    TextInput::make('plot_generator_total')
                        ->label('Total plots')
                        ->numeric()
                        ->minValue(1)
                        ->placeholder('38')
                        ->helperText('Total plots in this development.')
                        ->dehydrated(false),
                    TextInput::make('plot_generator_sold')
                        ->label('Sold')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->placeholder('35')
                        ->helperText('How many of those are already sold.')
                        ->dehydrated(false),
                    TextInput::make('plot_generator_reserved')
                        ->label('Reserved')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->helperText('Optional. The rest are marked available.')
                        ->dehydrated(false),
                    TextInput::make('plot_generator_prefix')
                        ->label('Plot number prefix')
                        ->placeholder('A')
                        ->default('A')
                        ->maxLength(20)
                        ->helperText('e.g. A gives A01, A02 on the website.')
                        ->dehydrated(false),
                    TextInput::make('plot_generator_start')
                        ->label('Start at')
                        ->numeric()
                        ->minValue(1)
                        ->default(1)
                        ->dehydrated(false),
                    TextInput::make('plot_generator_size')
                        ->label('Default size')
                        ->placeholder('50 x 100 ft')
                        ->maxLength(120)
                        ->default(fn (Get $get): ?string => filled($get('plot_size')) ? (string) $get('plot_size') : null)
                        ->dehydrated(false),
                    TextInput::make('plot_generator_price')
                        ->label('Default price')
                        ->numeric()
                        ->prefix('KES')
                        ->default(fn (Get $get): mixed => $get('price_from'))
                        ->dehydrated(false)
                        ->columnSpanFull(),
                ])
                ->columns(3)
                ->footerActions([
                    Action::make('generatePlotInventory')
                        ->label('Generate plot inventory')
                        ->icon(Heroicon::OutlinedSquaresPlus)
                        ->visible(fn (?Property $record): bool => $record?->exists ?? false)
                        ->requiresConfirmation(fn (Get $get): bool => count($get('plots') ?? []) > 0)
                        ->modalHeading('Replace plot inventory?')
                        ->modalDescription('This deletes all existing plots for this property and creates a new inventory immediately on the live website.')
                        ->modalSubmitActionLabel('Generate')
                        ->action(function (Get $get, Set $set, Property $record): void {
                            $total = max(0, (int) ($get('plot_generator_total') ?? 0));
                            $sold = max(0, (int) ($get('plot_generator_sold') ?? 0));
                            $reserved = max(0, (int) ($get('plot_generator_reserved') ?? 0));
                            $counts = PlotInventoryGenerator::replaceForProperty(
                                property: $record,
                                total: $total,
                                sold: $sold,
                                reserved: $reserved,
                                prefix: (string) ($get('plot_generator_prefix') ?? 'A'),
                                startNumber: max(1, (int) ($get('plot_generator_start') ?? 1)),
                                defaultSize: filled($get('plot_generator_size')) ? (string) $get('plot_generator_size') : null,
                                defaultPrice: filled($get('plot_generator_price')) ? (string) $get('plot_generator_price') : null,
                            );

                            if ($counts === null) {
                                Notification::make()
                                    ->title($total === 0 ? 'Enter total plots' : 'Counts do not add up')
                                    ->body($total === 0
                                        ? 'Set the total number of plots — for example 38 total with 35 sold.'
                                        : sprintf('Sold (%d) and reserved (%d) cannot exceed total plots (%d).', $sold, $reserved, $total))
                                    ->warning()
                                    ->send();

                                return;
                            }

                            $set('plots', PlotInventoryGenerator::formStateForProperty($record));

                            Notification::make()
                                ->title('Plot inventory saved')
                                ->body(sprintf(
                                    'Replaced with %d plots (%d sold, %d reserved, %d available). The public page is updated.',
                                    $counts['total'],
                                    $counts['sold'],
                                    $counts['reserved'],
                                    $counts['available'],
                                ))
                                ->success()
                                ->send();
                        }),
                ])
                ->columnSpanFull(),
            Section::make('Plot inventory')
                ->description('Add each plot and set its status. The public property page shows how many are sold and how many remain. When every plot is sold, visitors see “Sold out”.')
                ->schema([
                    Repeater::make('plots')
                        ->relationship('plots')
                        ->schema([
                            TextInput::make('plot_number')
                                ->label('Plot #')
                                ->required()
                                ->maxLength(50)
                                ->placeholder('A-01'),
                            Select::make('status')
                                ->options(PropertyFormOptions::plotStatuses())
                                ->required()
                                ->default('available')
                                ->native(false),
                            TextInput::make('size')
                                ->label('Size')
                                ->placeholder('50 x 100 ft')
                                ->maxLength(120),
                            TextInput::make('price')
                                ->numeric()
                                ->prefix('KES')
                                ->placeholder('850000'),
                        ])
                        ->columns(4)
                        ->addActionLabel('Add plot')
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => filled($state['plot_number'] ?? null)
                            ? ($state['plot_number'].' · '.ucfirst((string) ($state['status'] ?? 'available')))
                            : null)
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function mediaTab(): array
    {
        return [
            Section::make('Photos')
                ->description('Featured image powers property cards and the homepage. Gallery images appear on the full property page.')
                ->icon(Heroicon::OutlinedPhoto)
                ->extraAttributes(['class' => 'acremann-property-media-section'])
                ->schema([
                    View::make('filament.properties.media-preview')
                        ->columnSpanFull(),
                    FileUpload::make('hero_image')
                        ->label('Featured image')
                        ->image()
                        ->directory('properties/featured')
                        ->disk('public')
                        ->maxSize(5120)
                        ->imagePreviewHeight('18rem')
                        ->openable()
                        ->downloadable()
                        ->live()
                        ->helperText('One hero photo for cards and featured sections. Landscape 4:3 or 16:9 recommended.')
                        ->columnSpanFull(),
                    FileUpload::make('gallery_images')
                        ->label('Gallery')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->directory('properties/gallery')
                        ->disk('public')
                        ->maxFiles(24)
                        ->maxSize(5120)
                        ->imagePreviewHeight('14rem')
                        ->itemPanelAspectRatio('4/3')
                        ->panelLayout('grid')
                        ->openable()
                        ->downloadable()
                        ->live()
                        ->helperText('Drag images to reorder. The order here matches the public gallery grid.')
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function contentTab(): array
    {
        return [
            Section::make('Summaries')
                ->description('Short text for cards and search; full description for the property page.')
                ->schema([
                    FormComponents::richEditor('summary')
                        ->label('Short summary')
                        ->helperText('One or two sentences for listings and previews.'),
                    FormComponents::richEditor('description')
                        ->label('Full description')
                        ->helperText('Main body on the property page.'),
                ])
                ->columnSpanFull(),
            Section::make('Amenities & distances')
                ->schema([
                    Textarea::make('amenities')
                        ->label('Amenities')
                        ->rows(5)
                        ->formatStateUsing(fn (mixed $state): ?string => PropertyFormData::listToLines($state))
                        ->dehydrateStateUsing(fn (mixed $state): ?array => PropertyFormData::linesToList($state))
                        ->helperText('One amenity per line (e.g. Water, Graded roads, Security).')
                        ->columnSpanFull(),
                    Textarea::make('distance_notes')
                        ->label('Distance notes')
                        ->rows(4)
                        ->placeholder("15 min to Kikuyu town\n20 min to Southern Bypass")
                        ->helperText('One distance or landmark per line.')
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function trustTab(): array
    {
        return [
            Section::make('Title & process')
                ->description('Reassure buyers about clean title and conveyancing.')
                ->schema([
                    FormComponents::richEditor('title_process')
                        ->label('Clean title & process'),
                ])
                ->columnSpanFull(),
            Section::make('Investor angle')
                ->schema([
                    FormComponents::richEditor('investor_angle')
                        ->label('Why invest here'),
                ])
                ->columnSpanFull(),
            Section::make('Sustainability')
                ->schema([
                    Textarea::make('sustainability_markers')
                        ->label('Sustainability highlights')
                        ->rows(4)
                        ->formatStateUsing(fn (mixed $state): ?string => PropertyFormData::listToLines($state))
                        ->dehydrateStateUsing(fn (mixed $state): ?array => PropertyFormData::linesToList($state))
                        ->helperText('One highlight per line (e.g. 500+ trees planted).')
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function extrasTab(): array
    {
        return [
            Section::make('Map & virtual tour')
                ->schema([
                    Textarea::make('map_embed')
                        ->label('Google Maps embed code')
                        ->rows(4)
                        ->placeholder('<iframe src="https://www.google.com/maps/embed?..." ...></iframe>')
                        ->helperText('Paste the full iframe HTML from Google Maps → Share → Embed.')
                        ->columnSpanFull(),
                    TextInput::make('tour_embed_url')
                        ->label('Virtual tour URL')
                        ->url()
                        ->placeholder('https://...')
                        ->helperText('Matterport or similar embed URL for the property page.'),
                ])
                ->columnSpanFull(),
            Section::make('Brochure download')
                ->schema([
                    FileUpload::make('brochure_path')
                        ->label('Brochure PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('properties/brochures')
                        ->disk('public')
                        ->maxSize(10240)
                        ->downloadable()
                        ->openable()
                        ->helperText('Optional PDF for the “Download brochure” lead form.')
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected static function publishTab(): array
    {
        return [
            Section::make('Visibility')
                ->description('Control whether this property appears on the website and in featured areas.')
                ->icon(Heroicon::OutlinedEye)
                ->schema([
                    Toggle::make('is_published')
                        ->label('Published on website')
                        ->default(true)
                        ->required(),
                    Toggle::make('is_featured')
                        ->label('Featured on homepage')
                        ->helperText('Shows in homepage hero property grid when that mode is enabled. Separate from the featured photo above.')
                        ->required(),
                    TextInput::make('sort_order')
                        ->label('Sort order')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first in listings.'),
                ])
                ->columns(3)
                ->columnSpanFull(),
            Section::make('Search engine (SEO)')
                ->description('Optional overrides for Google and social previews.')
                ->icon(Heroicon::OutlinedMagnifyingGlass)
                ->collapsed()
                ->schema([
                    TextInput::make('meta_title')
                        ->label('Meta title')
                        ->maxLength(255)
                        ->placeholder('Plots for sale in Nachu Kikuyu | Acremann Nachu Gardens')
                        ->columnSpanFull(),
                    Textarea::make('meta_description')
                        ->label('Meta description')
                        ->rows(3)
                        ->maxLength(320)
                        ->helperText('Aim for ~150–160 characters with location and diaspora-friendly keywords.')
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ];
    }
}
