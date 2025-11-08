<?php

namespace App\Filament\Traits;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

trait NotifiesProjectManager
{
    /**
     * Get the project from the record.
     * For Project records, returns the record itself.
     * For Task records, returns the related project.
     */
    protected function getProject(): ?Project
    {
        $record = $this->record;

        if ($record instanceof Project) {
            return $record;
        }

        if ($record instanceof Task) {
            $record->load('project');

            return $record->project;
        }

        return null;
    }

    /**
     * Notify the project manager about a change.
     */
    protected function notifyProjectManager(string $title, string $body, string $type = 'success'): void
    {
        $project = $this->getProject();

        if (! $project) {
            return;
        }

        $manager = $project->manager();

        if (! $manager) {
            return;
        }

        $currentUser = Auth::user();

        if ($manager->id === $currentUser?->id) {
            return;
        }

        $notification = Notification::make()
            ->title($title)
            ->body($body);

        match ($type) {
            'success' => $notification->success(),
            'danger' => $notification->danger(),
            'warning' => $notification->warning(),
            'info' => $notification->info(),
            default => $notification->success(),
        };

        $manager->notify(
            $notification->toDatabase()
        );
    }

    /**
     * Notify the project manager about a deletion.
     * This method accepts the manager directly since the record won't be available after deletion.
     *
     * @param  User|null  $manager  The project manager to notify
     */
    protected function notifyProjectManagerOnDelete(string $title, string $body, ?User $manager = null, string $type = 'danger'): void
    {
        // If manager is not provided, try to get it from the project before deletion
        if (! $manager) {
            $project = $this->getProject();

            if (! $project) {
                return;
            }

            $manager = $project->manager();
        }

        if (! $manager) {
            return;
        }

        $currentUser = Auth::user();

        if ($manager->id === $currentUser?->id) {
            return;
        }

        $notification = Notification::make()
            ->title($title)
            ->body($body);

        match ($type) {
            'success' => $notification->success(),
            'danger' => $notification->danger(),
            'warning' => $notification->warning(),
            'info' => $notification->info(),
            default => $notification->danger(),
        };

        $manager->notify(
            $notification->toDatabase()
        );
    }
}
