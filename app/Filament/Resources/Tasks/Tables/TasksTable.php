<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Models\Task;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Kirschbaum\Commentions\Filament\Actions\CommentsAction;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->modifyQueryUsing(function ($query) use ($user) {
                // Managers can see all tasks in their projects
                if ($user->hasRole('manager')) {
                    return $query->whereHas('project.users', function ($q) use ($user) {
                        $q->where('users.id', $user->id);
                    });
                }

                // Members can only see tasks assigned to them in projects they have access to
                if ($user->hasRole('member')) {
                    return $query
                        ->where('user_id', $user->id)
                        ->whereHas('project.users', function ($q) use ($user) {
                            $q->where('users.id', $user->id);
                        });
                }

                // Admin already has full access via Gate::before
                return $query;
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('project.title')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('priority')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('modifiedBy.name')
                    ->label('Modified By')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->authorize(fn (Task $record) => auth()->user()->can('view', $record)),
                EditAction::make()
                    ->authorize(fn (Task $record) => auth()->user()->can('update', $record)),
                CommentsAction::make()
                    ->mentionables(User::all())
                    ->label('Comments')
                    ->authorize(fn (Task $record) => auth()->user()->can('view', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->authorize(fn () => auth()->user()->hasRole('manager')),
                ]),
            ]);
    }
}
