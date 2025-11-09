<?php

namespace App\Filament\Resources\Organizations\Api\Handlers;

use App\Filament\Resources\Organizations\Api\Transformers\OrganizationTransformer;
use App\Filament\Resources\Organizations\OrganizationResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = OrganizationResource::class;

    protected static string $permission = 'View:Organization';

    /**
     * Show Organization
     *
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

        if (! $query) {
            return static::sendNotFoundResponse();
        }

        return new OrganizationTransformer($query);
    }
}
