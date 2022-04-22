<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SizeResource;

class ColorResource extends JsonResource
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
            'color_id' => $this->color_id,
            'color_name' => $this->color_name,
            'product_price' => $this->product_price,
            'product_image1' => $this->product_image1,
            'product_image2' => $this->product_image2,
            'product_image3' => $this->product_image3,
            'product_image4' => $this->product_image4,
            'product_image5' => $this->product_image5,
            'sizes' => SizeResource::collection($this->sizes)
        ];
    }
}
