<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->product->name,
            'customer' => $this->customer,
            'review' => $this->review,
            'star' => $this->star
        ];
    }
}
