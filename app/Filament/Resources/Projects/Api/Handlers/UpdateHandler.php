<?php

namespace App\Filament\Resources\Projects\Api\Handlers;

use App\Filament\Resources\Projects\Api\Requests\UpdateProjectRequest;
use App\Filament\Resources\Projects\ProjectResource;
use Rupadana\ApiService\Http\Handlers;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = ProjectResource::class;

    protected static string $permission = 'Update:Project';

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Update Project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateProjectRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (! $model) {
            return static::sendNotFoundResponse();
        }

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Update Resource');
    }
}
