<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\ColorResource;

class ProductResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_description' => $this->product_description,
            'product_discount' => $this->product_discount,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'admin_updated_id' => $this->admin_updated_id,
            'admin_created_id' => $this->admin_created_id,
            // 'subcategory' => new SubCategoryResource($this->subcategory),
            'colors' => ColorResource::collection($this->colors)
        ];
    }
}
