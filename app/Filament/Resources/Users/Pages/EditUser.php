<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (! auth()->user()->can('update', $this->getRecord())) {
            abort(403);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->authorize(fn () => auth()->user()->can('view', $this->getRecord())),
            DeleteAction::make()
                ->authorize(fn () => auth()->user()->can('delete', $this->getRecord())),
        ];
    }
}
