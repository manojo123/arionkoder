<?php
namespace App\Filament\Resources\Organizations\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Organization;

/**
 * @property Organization $resource
 */
class OrganizationTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
