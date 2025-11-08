<?php

namespace App\Filament\Resources\Tasks\RelationManagers;

use App\Filament\Resources\Tasks\TaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ChildTasksRelationManager extends RelationManager
{
    protected static string $relationship = 'childTasks';

    protected static ?string $relatedResource = TaskResource::class;

    public function getTableHeading(): ?string
    {
        return 'Child Tasks';
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
