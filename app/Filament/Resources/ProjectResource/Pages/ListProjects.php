<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions; // v4

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    // munculkan tombol “Create”
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
