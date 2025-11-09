<?php
namespace App\Filament\Resources\Projects\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\Projects\ProjectResource;


class ProjectApiService extends ApiService
{
    protected static string | null $resource = ProjectResource::class;

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
