<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCat\PostCatStoreRequest;
use App\PostCat;
use App\User;
use Illuinate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;

class AdminPostCatController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post_cat']);

            return $next($request);
        });
    }

    function index()
    {
        $list_post_cat = PostCat::all();
        $list_post_cat = data_tree($list_post_cat);
        return view('admin.post_cat.index', compact('list_post_cat'));
    }

    function store(PostCatStoreRequest $request)
    {
        $post_cat_title = $request->input('post_cat_title');
        $slug = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($request->input('post_cat_title'));
        $parent_id = !empty($request->input('parent_id')) ? $request->input('parent_id') : '0';
        $data = array(
            'post_cat_title' => $post_cat_title,
            'slug' => $slug,
            'parent_id' => $parent_id,
        );
        PostCat::create($data);
    
        return redirect(Route('admin.post_cat.index'))->with('alert', 'Thêm danh mục thành công');
    }

    function edit($id)
    {
        $list_post_cat = PostCat::all();
        $list_post_cat = data_tree($list_post_cat);
        $post_cat = PostCat::find($id);
        return view('admin.post_cat.update', compact('list_post_cat', 'post_cat'));
    }

    function update(PostCatStoreRequest  $request, $id)
    {
        $post_cat_title = $request->input('post_cat_title');
        $slug = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($request->input('post_cat_title'));
        $parent_id = !empty($request->input('parent_id')) ? $request->input('parent_id') : '0';
        PostCat::where('id', $id)->update([
            'post_cat_title' => $post_cat_title,
            'slug' => $slug,
            'parent_id' => $parent_id,
        ]);
        return redirect(Route('admin.post_cat.index'))->with('alert', 'Cập nhật danh mục thành công');
    }

    function destroy($id)
    {
             $list_post_cat = PostCat::all();
        $list_post_cat = data_tree($list_post_cat, $id);
        $ids = array_map(function ($item) {
            return $item->id;
        }, $list_post_cat);
        $ids[] = $id;
        PostCat::whereIn('id', $ids)->delete();
        return redirect(Route('admin.post_cat.index'))->with('alert', 'Xóa danh mục thành công');
    }
}
