<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Resources\Resource;

// v4 form container
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

// Forms
use Filament\Forms\Components\{TextInput, Textarea, Toggle};

// Tables
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, ToggleColumn};
use Filament\Tables\Filters\TernaryFilter;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    // tampil di menu (pakai string icon agar aman)
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationLabel = 'Contacts';
    protected static ?int $navigationSort = 50;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-inbox';
    protected static \UnitEnum|string|null   $navigationGroup = 'Content';

    /** read-only form untuk halaman view/edit */
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Message')->columns(12)->schema([
                TextInput::make('name')->disabled()->columnSpan(6),
                TextInput::make('email')->disabled()->columnSpan(6),
                TextInput::make('subject')->disabled()->columnSpan(12),
                Textarea::make('message')->rows(8)->disabled()->columnSpanFull(),
                Toggle::make('is_read')->label('Read')->inline(false)->columnSpan(3),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Time')->dateTime('d M Y H:i')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('subject')->limit(30)->wrap(),
                TextColumn::make('message')->label('Preview')->limit(60)->wrap(),
                ToggleColumn::make('is_read')->label('Read'),
            ])
            ->filters([
                TernaryFilter::make('is_read')->label('Read'),
            ])
            // klik baris -> edit (form read-only + toggle read)
            ->recordUrl(fn (ContactMessage $r) => static::getUrl('edit', ['record' => $r]))
            // kosongkan actions supaya aman di v4
            ->actions([])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'edit'  => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
