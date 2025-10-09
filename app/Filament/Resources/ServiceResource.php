<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Form builder v4: container pakai Schema + Section
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

// Komponen form (tetap dari Forms)
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;

use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    // Tampil di menu
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationLabel = 'Services';
    protected static ?int    $navigationSort  = 11;
    // Ikon aman berupa string (anti enum/versi)
    protected static \BackedEnum|string|null $navigationIcon  = 'heroicon-o-wrench-screwdriver';
    protected static \UnitEnum|string|null   $navigationGroup = 'Content';

    /** FORM (Filament v4) */
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Details')->columns(12)->schema([
                TextInput::make('name')
                    ->label('Service')
                    ->required()
                    ->maxLength(120)
                    ->live(onBlur: true)
                    // TANPA type-hint Set agar tidak tabrakan (Forms\Set vs Schemas\Set)
                    ->afterStateUpdated(function ($set, ?string $state) {
                        $set('slug', Str::slug((string) $state));
                    })
                    ->columnSpan(6),

                TextInput::make('slug')
                    ->maxLength(140)
                    ->unique(ignoreRecord: true)
                    ->columnSpan(6),

                TextInput::make('category')
                    ->datalist(['Web', 'Mobile', 'Backend', 'UI/UX'])
                    ->columnSpan(4),

                TextInput::make('icon')
                    ->placeholder('Emoji / teks, contoh: 🚀 atau nama heroicon')
                    ->columnSpan(4),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->columnSpan(4),

                Textarea::make('short_description')
                    ->rows(3)
                    ->columnSpanFull(),

                TagsInput::make('features')
                    ->placeholder('Tambah fitur lalu Enter')
                    ->columnSpanFull(),

                TextInput::make('price_monthly')
                    ->numeric()
                    ->prefix('Rp')
                    ->columnSpan(6),

                TextInput::make('price_yearly')
                    ->numeric()
                    ->prefix('Rp')
                    ->columnSpan(6),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->columnSpan(3),
            ]),
        ]);
    }

    /** TABLE (Filament v4) */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Service')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_monthly')
                    ->label('Monthly')
                    ->formatStateUsing(fn ($state) => is_null($state) ? '—' : 'Rp ' . number_format((float) $state, 0, ',', '.')),

                Tables\Columns\TextColumn::make('price_yearly')
                    ->label('Yearly')
                    ->toggleable(true)
                    ->formatStateUsing(fn ($state) => is_null($state) ? '—' : 'Rp ' . number_format((float) $state, 0, ',', '.')),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sort order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->options(
                    fn () => Service::query()
                        ->whereNotNull('category')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->toArray()
                ),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            // Klik baris -> Edit
            ->recordUrl(fn ($record) => static::getUrl('edit', ['record' => $record]))
            // Kosongkan actions & bulkActions agar anti-CLASS NOT FOUND pada v4
            ->actions([])
            ->bulkActions([])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
