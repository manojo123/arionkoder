<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Kirschbaum\Commentions\Filament\Actions\CommentsAction;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->modifyQueryUsing(function ($query) use ($user) {
                // Managers can see all projects
                if ($user->hasRole('manager')) {
                    return $query;
                }

                // Members can only see projects they're part of
                if ($user->hasRole('member')) {
                    return $query->whereHas('users', function ($q) use ($user) {
                        $q->where('users.id', $user->id);
                    });
                }

                // Admin already has full access via Gate::before
                return $query;
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('organization.name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
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
                    ->authorize(fn (Project $record) => auth()->user()->can('view', $record)),
                EditAction::make()
                    ->authorize(fn (Project $record) => auth()->user()->can('update', $record)),
                CommentsAction::make()
                    ->mentionables(User::all())
                    ->label('Comments')
                    ->authorize(fn (Project $record) => auth()->user()->can('view', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->authorize(fn () => auth()->user()->hasRole('manager')),
                ]),
            ]);
    }
}
