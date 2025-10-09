<?php

namespace App\Filament\Resources\NavItems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NavItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required(),
                TextInput::make('position')
                    ->required()
                    ->default('header'),
                TextInput::make('link_type')
                    ->required()
                    ->default('route'),
                TextInput::make('route_name'),
                Textarea::make('params')
                    ->columnSpanFull(),
                TextInput::make('url'),
                TextInput::make('parent_id')
                    ->numeric(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('open_new_tab')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
