<?php

namespace App\Filament\Resources\Projects\Api\Handlers;

use App\Filament\Resources\Projects\Api\Transformers\ProjectTransformer;
use App\Filament\Resources\Projects\ProjectResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = ProjectResource::class;

    protected static string $permission = 'View:Project';

    /**
     * Show Project
     *
     * @return ProjectTransformer
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

        return new ProjectTransformer($query);
    }
}
