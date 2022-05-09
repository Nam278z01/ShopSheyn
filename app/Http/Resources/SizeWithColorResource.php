<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SizeWithColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'size_id' => $this->size_id,
            'size_name' => $this->size_name,
            'quantity' => $this->quantity,
            'color' => new ColorWithProductResource($this->color)
        ];
    }
}
