<?php

namespace App\Filament\Resources\Organizations\Pages;

use App\Filament\Resources\Organizations\OrganizationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganization extends ViewRecord
{
    protected static string $resource = OrganizationResource::class;

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
