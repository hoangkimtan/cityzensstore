<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id',
        'qty',
        'price',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo("App\Product")->withTrashed();
    }

}
