<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    // php artisan make:resource Product/ProductResource
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'name' => $this->name,
            'description' => $this->details,
            'price' => $this->price,
            'stock' => $this->stock == 0 ? "Out of Stock" : $this->stock,
            'discount' => $this->discount,
            'totalPrice' => $this->discount != 0 ? round($this->price - ($this->price * $this->discount)/100 , 2) : $this->price,
            'rating' => $this->reviews->count() > 0 ? round( $this->reviews->sum('star') /$this->reviews->count()) : 'No Rating yet',
            'reviews' => route('reviews.index',['product'=>$this->id]),
        ];
    }
}
