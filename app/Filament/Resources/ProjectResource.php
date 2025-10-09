<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// v4: form container pakai Schema + Section
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

// Komponen input tetap dari Forms\Components
use Filament\Forms\Components\{TextInput, Textarea, FileUpload, Toggle, DateTimePicker};

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    // tampil di menu
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationLabel = 'Projects';
    protected static ?int $navigationSort = 10;

    // v4 aman: string icon
    protected static \BackedEnum|string|null $navigationIcon  = 'heroicon-o-rocket-launch';
    protected static \UnitEnum|string|null  $navigationGroup = 'Content';

    /** FORM — aman, tanpa afterStateUpdated(Set ...) */
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Details')->columns(12)->schema([
                TextInput::make('title')
                    ->required()->maxLength(150)
                    ->columnSpan(8),

                TextInput::make('slug') // biarkan kosong, akan diisi otomatis di Model (lihat langkah 3)
                    ->maxLength(170)
                    ->unique(ignoreRecord: true)
                    ->columnSpan(4),

                TextInput::make('category')
                    ->label('Category')
                    ->required()
                    ->datalist(['Web','Mobile','Desktop','API'])
                    ->default('General')
                    ->columnSpan(4),

                FileUpload::make('image_url')
                    ->label('Cover Image')
                    ->image()
                    ->directory('projects') // public/projects
                    ->disk('public')
                    ->visibility('public')
                    ->columnSpan(8),

                Textarea::make('description')
                    ->rows(6)
                    ->columnSpanFull(),
            ]),

            Section::make('Publishing')->columns(12)->schema([
                TextInput::make('demo_url')->url()->columnSpan(6),
                TextInput::make('github_url')->url()->columnSpan(6),

                Toggle::make('is_published')->label('Published')
                    ->default(true)->columnSpan(3),

                DateTimePicker::make('published_at')
                    ->native(false)->seconds(false)
                    ->columnSpan(5),
            ]),
        ]);
    }

    /** TABLE — klik baris langsung masuk Edit; tanpa row/bulk actions (supaya anti error) */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Cover')
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->badge()->sortable(),
                Tables\Columns\ToggleColumn::make('is_published')->label('Published'),
                Tables\Columns\TextColumn::make('published_at')->dateTime('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->since()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->options(fn () =>
                    Project::query()
                        ->whereNotNull('category')
                        ->distinct()->orderBy('category')
                        ->pluck('category', 'category')->toArray()
                ),
                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
            ])

            // klik baris -> Edit
            ->recordUrl(fn (Project $record) => static::getUrl('edit', ['record' => $record]))

            // biarkan kosong (menghindari kelas aksi yang bikin ClassNotFound)
            ->actions([])
            ->bulkActions([])

            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
