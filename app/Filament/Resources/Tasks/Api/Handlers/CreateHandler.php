<?php
namespace App\Filament\Resources\Tasks\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\Tasks\TaskResource;
use App\Filament\Resources\Tasks\Api\Requests\CreateTaskRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = TaskResource::class;
    protected static string $permission = 'Create:Task';

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Task
     *
     * @param CreateTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateTaskRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}