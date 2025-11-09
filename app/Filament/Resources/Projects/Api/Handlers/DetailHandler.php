<?php

namespace App\Filament\Resources\Projects\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\Projects\ProjectResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\Projects\Api\Transformers\ProjectTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ProjectResource::class;
    protected static string $permission = 'View:Project';


    /**
     * Show Project
     *
     * @param Request $request
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

        if (!$query) return static::sendNotFoundResponse();

        return new ProjectTransformer($query);
    }
}
