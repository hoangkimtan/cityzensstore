<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'fullname',
        'email',
        'orderCode',
        'phone',
        'note',
        'payment',
        'status',
        'total_product',
        'total',
        'address',
        'customer_id'
    ];

    function products()
    {
        return $this->belongsToMany("App\Product");
    }

    public function orderDetail()
    {
        return $this->hasMany("App\OrderDetail");
    }
}
