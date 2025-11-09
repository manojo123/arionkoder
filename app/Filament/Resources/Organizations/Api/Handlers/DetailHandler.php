<?php

namespace App\Filament\Resources\Organizations\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\Organizations\OrganizationResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\Organizations\Api\Transformers\OrganizationTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = OrganizationResource::class;
    protected static string $permission = 'View:Organization';


    /**
     * Show Organization
     *
     * @param Request $request
     * @return OrganizationTransformer
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

        return new OrganizationTransformer($query);
    }
}
