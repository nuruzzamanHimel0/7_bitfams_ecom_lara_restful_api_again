<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [''];

    public function reviews()
    {
        return $this->hasMany('App\Model\Review','product_id','id');
    }
}
