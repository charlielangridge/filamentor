<?php

namespace Geosem42\Filamentor\Resources;

use Filament\Forms;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Geosem42\Filamentor\Models\Page;
use Geosem42\Filamentor\Support\LayoutState;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Basic Information')
                    ->columnSpan(9)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $state, Set $set) =>
                                $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                    ]),

                Section::make('Publishing')
                    ->columnSpan(3)
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->default(false)
                            ->helperText('Make this page visible to the public'),
                    ]),

                Forms\Components\Hidden::make('layout')
                ->default('[]')
                ->afterStateHydrated(function ($component, $state) {
                    $component->state(LayoutState::toJsonString($state));
                })
                ->dehydrateStateUsing(fn ($state) => LayoutState::toJsonString($state)),

            ])
            ->columns(12);

    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug')->prefix('/'),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => PageResource\Pages\ListPages::route('/'),
            'create' => PageResource\Pages\CreatePage::route('/create'),
            'edit' => PageResource\Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return (string) config('filamentor.resource_slug', 'filamentor-pages');
    }

}
