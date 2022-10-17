<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $guarded = ['_token'];
    
    function post_cat()
    {
        return $this->belongsTo('App\PostCat');
    }
}
