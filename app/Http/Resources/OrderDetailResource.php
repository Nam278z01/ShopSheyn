<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SizeColorResource;

class OrderDetailResource extends JsonResource
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
            'orderdetail_id' => $this->orderdetail_id,
            'product_discount' => $this->product_discount,
            'product_quantity' => $this->product_quantity,
            'customer_address' => $this->customer_address,
            'price' => $this->price,
            'size' => new SizeWithColorResource($this->size)
        ];
    }
}
