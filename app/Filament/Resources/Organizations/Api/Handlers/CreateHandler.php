<?php
namespace App\Filament\Resources\Organizations\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\Organizations\OrganizationResource;
use App\Filament\Resources\Organizations\Api\Requests\CreateOrganizationRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = OrganizationResource::class;
    protected static string $permission = 'Create:Organization';

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Organization
     *
     * @param CreateOrganizationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateOrganizationRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}