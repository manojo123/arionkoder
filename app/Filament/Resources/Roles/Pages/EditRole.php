<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
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
            ViewAction::make()
                ->authorize(fn () => auth()->user()->hasRole('admin')),
            DeleteAction::make()
                ->authorize(fn () => auth()->user()->hasRole('admin')),
        ];
    }
}
