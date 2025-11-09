<?php

namespace App\Filament\Resources\Tasks\Api\Handlers;

use App\Filament\Resources\Tasks\Api\Requests\CreateTaskRequest;
use App\Filament\Resources\Tasks\TaskResource;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = TaskResource::class;

    protected static string $permission = 'Create:Task';

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Create Task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateTaskRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Resource');
    }
}
