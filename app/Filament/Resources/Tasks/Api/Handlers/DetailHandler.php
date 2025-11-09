<?php

namespace App\Filament\Resources\Tasks\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\Tasks\TaskResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\Tasks\Api\Transformers\TaskTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = TaskResource::class;
    protected static string $permission = 'View:Task';


    /**
     * Show Task
     *
     * @param Request $request
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

        if (!$query) return static::sendNotFoundResponse();

        return new TaskTransformer($query);
    }
}
