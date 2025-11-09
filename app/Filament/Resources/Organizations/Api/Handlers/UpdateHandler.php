<?php
namespace App\Filament\Resources\Organizations\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\Organizations\OrganizationResource;
use App\Filament\Resources\Organizations\Api\Requests\UpdateOrganizationRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = OrganizationResource::class;
    protected static string $permission = 'Update:Organization';

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Organization
     *
     * @param UpdateOrganizationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateOrganizationRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}