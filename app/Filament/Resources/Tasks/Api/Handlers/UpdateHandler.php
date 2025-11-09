<?php
namespace App\Filament\Resources\Tasks\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\Tasks\TaskResource;
use App\Filament\Resources\Tasks\Api\Requests\UpdateTaskRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = TaskResource::class;
    protected static string $permission = 'Update:Task';

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Task
     *
     * @param UpdateTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateTaskRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}