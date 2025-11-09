<?php

namespace App\Filament\Resources\Tasks\Api\Transformers;

use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Task $resource
 */
class TaskTransformer extends JsonResource
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
