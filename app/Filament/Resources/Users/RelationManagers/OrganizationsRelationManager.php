<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Organizations\OrganizationResource;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class OrganizationsRelationManager extends RelationManager
{
    protected static string $relationship = 'organizations';

    protected static ?string $relatedResource = OrganizationResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
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
