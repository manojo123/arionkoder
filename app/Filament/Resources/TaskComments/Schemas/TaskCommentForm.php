<?php

namespace App\Filament\Resources\TaskComments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TaskCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('task_id')
                    ->relationship('task', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
