<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    protected $table = 'product_img_relatives';
    protected $fillable = ['img_relative_thumb','product_id'];
}
