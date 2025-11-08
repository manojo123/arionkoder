<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Traits\NotifiesProjectManager;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    use NotifiesProjectManager;

    protected static string $resource = ProjectResource::class;

    protected ?string $projectTitle = null;
    protected $projectManager = null;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->before(function () {
                    $this->projectTitle = $this->record->title;
                    $this->projectManager = $this->record->manager();
                })
                ->after(function () {
                    $this->notifyProjectManagerOnDelete(
                        'Project deleted',
                        "Project '{$this->projectTitle}' has been deleted.",
                        $this->projectManager,
                        'danger'
                    );
                }),
        ];
    }

    protected function afterSave(): void
    {
        $this->notifyProjectManager(
            'Project updated',
            "Project '{$this->record->title}' has been updated.",
            'success'
        );
    }
}
