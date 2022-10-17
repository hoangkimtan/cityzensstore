<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    protected $table = 'product_cats';
    protected $guarded = [];
    
    function Products()
    {
        return $this->hasMany("App\Product");
    }
}
