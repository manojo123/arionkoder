<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Select::make('project_id')
                    ->relationship('project', 'title')
                    ->required(),
                Select::make('task_id')
                    ->relationship('parentTask', 'title')
                    ->label('Parent Task'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Assignee')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('priority')
                    ->options(collect(TaskPriority::cases())->mapWithKeys(fn ($case) => [$case->value => $case->value]))
                    ->required()
                    ->default(TaskPriority::Low->value),
                Select::make('status')
                    ->options(collect(TaskStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->value]))
                    ->required()
                    ->default(TaskStatus::Backlog->value),
                DatePicker::make('due_date'),
            ]);
    }
}
