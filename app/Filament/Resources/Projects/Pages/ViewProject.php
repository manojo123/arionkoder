<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (! auth()->user()->can('view', $this->getRecord())) {
            abort(403);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->authorize(fn () => auth()->user()->can('update', $this->getRecord())),
        ];
    }
}
