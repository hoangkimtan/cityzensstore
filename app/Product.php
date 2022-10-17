<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $guarded = ['btn_add', '_token'];
    protected $with = ['productCat'];

    function productCat()
    {
        return $this->belongsTo("App\ProductCat");
    }

    function orders()
    {
        return $this->belongsToMany("App\Order");
    }

}
