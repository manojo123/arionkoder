<?php

namespace App\Filament\Resources\Organizations\Api;

use App\Filament\Resources\Organizations\OrganizationResource;
use Rupadana\ApiService\ApiService;

class OrganizationApiService extends ApiService
{
    protected static ?string $resource = OrganizationResource::class;

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
