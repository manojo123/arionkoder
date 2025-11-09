<?php

namespace App\Filament\Resources\Tasks\Api\Handlers;

use App\Filament\Resources\Tasks\Api\Requests\UpdateTaskRequest;
use App\Filament\Resources\Tasks\TaskResource;
use Rupadana\ApiService\Http\Handlers;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = TaskResource::class;

    protected static string $permission = 'Update:Task';

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Update Task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateTaskRequest $request)
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
