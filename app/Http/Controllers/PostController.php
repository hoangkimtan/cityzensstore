<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function list($post_cat_id = "")
    {
        $list_post = Post::where('status', '=', 'publish')->orderBy('id', 'DESC')->paginate(4);
        if ($post_cat_id) {
            $list_post = Post::where('status', '=', 'publish')->where('post_cat_id', '=', $post_cat_id)->orderBy('id', 'DESC')->paginate(4);
        }
        return view('post.post_list', compact('list_post'));
    }

    public function detail($slug, $id)
    {
        $post = Post::where('status', 'publish')->find($id);
        return view('post.post_detail', compact('post'));
    }
}
