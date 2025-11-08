<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use App\Filament\Traits\NotifiesProjectManager;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    use NotifiesProjectManager;

    protected static string $resource = TaskResource::class;

    protected function afterCreate(): void
    {
        $task = $this->record;

        $this->notifyProjectManager(
            'New task created',
            "A new task '{$task->title}' has been created in project '{$task->project->title}'.",
            'success'
        );
    }
}
