<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\Task;
use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.title')
                    ->label('Project'),
                TextEntry::make('user.name')
                    ->label('Assignee'),
                TextEntry::make('parentTask.title')
                    ->label('Parent Task'),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('priority'),
                TextEntry::make('status'),
                TextEntry::make('due_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('createdBy.name')
                    ->label('Created By'),
                TextEntry::make('modifiedBy.name')
                    ->label('Modified By'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Task $record): bool => $record->trashed()),
                CommentsEntry::make('comments')
                    ->mentionables(User::all())
                    ->label('Comments')
                    ->columnSpanFull(),
            ]);
    }
}
