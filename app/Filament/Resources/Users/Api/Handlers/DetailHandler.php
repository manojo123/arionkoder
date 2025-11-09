<?php

namespace App\Filament\Resources\Users\Api\Handlers;

use App\Filament\Resources\Users\Api\Transformers\UserTransformer;
use App\Filament\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class DetailHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = UserResource::class;

    protected static string $permission = 'View:User';

    /**
     * Show User
     *
     * @return UserTransformer
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

        return new UserTransformer($query);
    }
}
