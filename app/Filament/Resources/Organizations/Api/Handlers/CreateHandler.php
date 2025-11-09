<?php

namespace App\Filament\Resources\Organizations\Api\Handlers;

use App\Filament\Resources\Organizations\Api\Requests\CreateOrganizationRequest;
use App\Filament\Resources\Organizations\OrganizationResource;
use Rupadana\ApiService\Http\Handlers;

class CreateHandler extends Handlers
{
    public static ?string $uri = '/';

    public static ?string $resource = OrganizationResource::class;

    protected static string $permission = 'Create:Organization';

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Create Organization
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateOrganizationRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, 'Successfully Create Resource');
    }
}
