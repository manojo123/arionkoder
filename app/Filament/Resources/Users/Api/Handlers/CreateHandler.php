<?php

namespace App\Filament\Resources\Users\Api\Handlers;

use App\Filament\Resources\Users\Api\Requests\CreateUserRequest;
use App\Filament\Resources\Users\UserResource;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = UserResource::class;

    protected static string $permission = 'Create:User';

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Create User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateUserRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Resource');
    }
}
