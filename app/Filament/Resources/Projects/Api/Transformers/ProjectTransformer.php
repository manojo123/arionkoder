<?php

namespace App\Filament\Resources\Projects\Api\Transformers;

use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Project $resource
 */
class ProjectTransformer extends JsonResource
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
