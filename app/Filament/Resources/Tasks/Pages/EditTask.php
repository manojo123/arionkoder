<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use App\Filament\Traits\NotifiesProjectManager;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTask extends EditRecord
{
    use NotifiesProjectManager;

    protected static string $resource = TaskResource::class;

    protected ?string $taskTitle = null;
    protected ?string $projectTitle = null;
    protected $projectManager = null;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->before(function () {
                    $this->taskTitle = $this->record->title;
                    $this->projectTitle = $this->record->project?->title;
                    $this->projectManager = $this->record->project?->manager();
                })
                ->after(function () {
                    $this->notifyProjectManagerOnDelete(
                        'Task deleted',
                        "Task '{$this->taskTitle}' has been deleted from project '{$this->projectTitle}'.",
                        $this->projectManager,
                        'danger'
                    );
                }),
        ];
    }

    protected function afterSave(): void
    {
        $task = $this->record;

        $this->notifyProjectManager(
            'Task updated',
            "Task '{$task->title}' has been updated in project '{$task->project->title}'.",
            'success'
        );
    }
}
