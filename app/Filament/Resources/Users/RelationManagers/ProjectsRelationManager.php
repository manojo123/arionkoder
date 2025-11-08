<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $relatedResource = ProjectResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pivot.role')
                    ->label('Project Role'),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('role')->required()->default('member'),
                ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
