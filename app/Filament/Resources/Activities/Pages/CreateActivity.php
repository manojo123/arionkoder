<?php

namespace App\Filament\Resources\Activities\Pages;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;

    public function mount(): void
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
    }
}
