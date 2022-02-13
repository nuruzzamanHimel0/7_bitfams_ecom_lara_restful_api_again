<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class ProductCollection extends Resource
{


    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'discount' => $this->discount,
            'totalPrice' => $this->discount != 0 ? round($this->price - ($this->price * $this->discount)/100 , 2) : $this->price,
            'rating' => $this->reviews->count() > 0 ? round( $this->reviews->sum('star') /$this->reviews->count()) : 'No Rating yet',
            'href' => [
                'link' => route('products.show', $this->id )
            ]
        ];
        // return parent::toArray($request);
    }
}
