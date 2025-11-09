<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->authorize(fn () => auth()->user()->hasRole('admin')),
        ];
    }
}
