<?php

namespace App\Filament\Resources\Projects\Api\Handlers;

use App\Filament\Resources\Projects\ProjectResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class DeleteHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = ProjectResource::class;

    protected static string $permission = 'Delete:Project';

    public static function getMethod()
    {
        return Handlers::DELETE;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Delete Project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (! $model) {
            return static::sendNotFoundResponse();
        }

        $model->delete();

        return static::sendSuccessResponse($model, 'Successfully Delete Resource');
    }
}
