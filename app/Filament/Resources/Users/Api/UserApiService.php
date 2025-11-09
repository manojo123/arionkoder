<?php

namespace App\Filament\Resources\Users\Api;

use App\Filament\Resources\Users\UserResource;
use Rupadana\ApiService\ApiService;

class UserApiService extends ApiService
{
    protected static ?string $resource = UserResource::class;

    public static function handlers(): array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class,
        ];

    }
}
