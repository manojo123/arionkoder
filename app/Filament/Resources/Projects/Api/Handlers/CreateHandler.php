<?php

namespace App\Filament\Resources\Projects\Api\Handlers;

use App\Filament\Resources\Projects\Api\Requests\CreateProjectRequest;
use App\Filament\Resources\Projects\ProjectResource;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = ProjectResource::class;

    protected static string $permission = 'Create:Project';

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Create Project
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateProjectRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Resource');
    }
}
