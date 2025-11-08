<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Traits\NotifiesProjectManager;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    use NotifiesProjectManager;

    protected static string $resource = ProjectResource::class;

    protected function afterCreate(): void
    {
        $project = $this->record;

        $this->notifyProjectManager(
            'New project created',
            "A new project '{$project->title}' has been created and you have been assigned as manager.",
            'success'
        );
    }
}
