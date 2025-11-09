<?php

namespace App\Filament\Resources\Organizations\Api\Handlers;

use App\Filament\Resources\Organizations\Api\Requests\UpdateOrganizationRequest;
use App\Filament\Resources\Organizations\OrganizationResource;
use Rupadana\ApiService\Http\Handlers;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}';

    public static ?string $resource = OrganizationResource::class;

    protected static string $permission = 'Update:Organization';

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    /**
     * Update Organization
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateOrganizationRequest $request)
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
