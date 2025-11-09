<?php
namespace App\Filament\Resources\Organizations\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\Organizations\OrganizationResource;


class OrganizationApiService extends ApiService
{
    protected static string | null $resource = OrganizationResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
