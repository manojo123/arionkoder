<?php

namespace App\Filament\Resources\Organizations\Tables;

use App\Models\Organization;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class OrganizationsTable
{
    public static function configure(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->modifyQueryUsing(function ($query) use ($user) {
                // Users and managers can only see organizations they belong to
                if ($user->hasRole('manager') || $user->hasRole('member')) {
                    return $query->whereHas('users', function ($q) use ($user) {
                        $q->where('users.id', $user->id);
                    });
                }

                // Admin already has full access via Gate::before
                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->authorize(fn (Organization $record) => auth()->user()->can('view', $record)),
                EditAction::make()
                    ->authorize(fn (Organization $record) => auth()->user()->can('update', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->authorize(fn () => auth()->user()->hasRole('admin')),
                ]),
            ]);
    }
}
