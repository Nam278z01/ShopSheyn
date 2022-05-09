<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'order_id' => $this->order_id,
            'order_date' => $this->order_date,
            'customer_name' => $this->customer_name,
            'customer_address' => $this->customer_address,
            'customer_phone' => $this->customer_phone,
            'note' => $this->note,
            'delivery_cost' => $this->delivery_cost,
            'total' => $this->total,
            'orderdetails' => OrderDetailResource::collection($this->orderdetails),
            'orderstates' => OrderStateResource::collection($this->orderstates),
        ];
    }
}
