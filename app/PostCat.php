<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCat extends Model
{
    protected $table = 'post_cats';
    protected $guarded = [];
    //Mặc định Eager loading
    // protected $with = ['posts'];

    function posts()
    {
        return $this->hasMany('App\Post');
    }
}
