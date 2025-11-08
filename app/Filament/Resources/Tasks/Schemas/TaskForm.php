<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Assignee')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('priority')
                    ->required()
                    ->default('low'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DatePicker::make('due_date'),
            ]);
    }
}
