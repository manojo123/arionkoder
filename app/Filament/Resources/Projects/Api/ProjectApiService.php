<?php

namespace App\Filament\Resources\Projects\Api;

use App\Filament\Resources\Projects\ProjectResource;
use Rupadana\ApiService\ApiService;

class ProjectApiService extends ApiService
{
    protected static ?string $resource = ProjectResource::class;

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
