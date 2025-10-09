<?php
namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Resources\Pages\EditRecord;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    // Sembunyikan tombol simpan agar benar2 view-only (kecuali toggle Read)
    protected function getFormActions(): array
    {
        return []; // tidak ada tombol
    }
}
