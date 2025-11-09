<?php

namespace App\Filament\Resources\Tasks\Api\Handlers;

use App\Filament\Resources\Tasks\Api\Transformers\TaskTransformer;
use App\Filament\Resources\Tasks\TaskResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = TaskResource::class;

    protected static string $permission = 'View:Task';

    /**
     * Show Task
     *
     * @return TaskTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (! $query) {
            return static::sendNotFoundResponse();
        }

        return new TaskTransformer($query);
    }
}
