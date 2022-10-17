<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\PostCat;

class AdminPostController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);

            return $next($request);
        });
    }

    function index(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'pending' => 'Chờ duyệt',
            'trash' => 'Xóa tạm thời',
        ];
        if (!$status) {
            $list_post = Post::with('post_cat')->orderBy('id','desc')->paginate(10);
            $list_post->appends(['status' => $status]);
        } elseif ($status == "publish") {
            $list_post = Post::with('post_cat')->where('status', '=', 'publish')->paginate(10);
            $list_post->appends(['status' => $status]);
        } elseif ($status == "pending") {
            $list_act = [
                'publish' => 'Xuất bản',
                'trash' => 'Xóa tạm thời'
            ];
            $list_post = Post::with('post_cat')->where('status', '=', 'pending')->paginate(10);
            $list_post->appends(['status' => $status]);
        } elseif ($status == "trash") {
            $list_act = [
                'restore' => 'Khôi phục',
                'forcedelete' => 'Xóa vĩnh viễn'
            ];
            $list_post = Post::with('post_cat')->onlyTrashed()->paginate(10);
            $list_post->appends(['status' => $status]);
        }
        if ($request->input('key')) {
            $key = $request->input('key');
            $list_post = Post::with('post_cat')->where('post_title', "LIKE", "%{$key}%")->paginate(10);
            $list_post->appends(['key' => $key]);
        }

        $num_all = Post::count();
        $num_publish = Post::where('status', '=', 'publish')->count();
        $num_pending = Post::where('status', '=', 'pending')->count();
        $num_trash = Post::onlyTrashed()->count();
        $count = array($num_all, $num_publish, $num_pending, $num_trash);
        return view('admin.post.index', compact('list_post', 'list_act', 'count'));
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        $action = $request->input('action');
        $request->input('page') ? $request->input('page') : 1;
        if (!$list_check) {
            return redirect(Route('admin.post.index'))->with('alert', 'Bạn chưa chọn bài viết nào để thao tác');
        } else {
            if (!$action) {
                return redirect(Route('admin.post.index'))->with('alert', 'Bạn chưa chọn hành động nào để thao tác');
            } else {
                if ($action == "trash") {
                    Post::destroy($list_check);
                    return redirect(Route('admin.post.index'))->with('alert', 'Xóa tạm thời thành công');
                } elseif ($action == "pending") {
                    Post::whereIn('id', $list_check)->update([
                        'status' => 'pending'
                    ]);
                    return redirect(Route('admin.post.index'))->with('alert', 'Cập nhật thành công');
                } elseif ($action == "publish") {
                    Post::whereIn('id', $list_check)->update([
                        'status' => 'publish'
                    ]);
                    return redirect(Route('admin.post.index'))->with('alert', 'Cập nhật thành công');
                } elseif ($action == "restore") {
                    Post::whereIn('id', $list_check)->restore();
                    return redirect(Route('admin.post.index'))->with('alert', 'Cập nhật thành công');
                } else {
                    Post::whereIn('id', $list_check)->forceDelete();
                    return redirect(Route('admin.post.index'))->with('alert', 'Xoá thành công');
                }
            }
        }
    }

    function create()
    {
        $list_post_cat = PostCat::all();
        $list_post_cat = data_tree($list_post_cat);
        return view('admin.post.add', compact('list_post_cat'));
    }

    function store(PostStoreRequest $request)
    {
        $input = $request->all();
        if ($request->hasFile('post_thumb')) {
            $file = $request->post_thumb;
            $file->getCLientOriginalName();
            $file->move('public/upload/post/', $file->getClientOriginalName());
            $input['post_thumb'] = "/upload/post/" . $file->getClientOriginalName();
        }
        $input['slug'] = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($request->input('post_title'));
        Post::create($input);
        return redirect(Route('admin.post.index'))->with('alert', 'Thêm bài viết thành công');
    }

    public function edit($id)
    {
        $list_post_cat = PostCat::all();
        $list_post_cat = data_tree($list_post_cat);
        $post = Post::withTrashed()->find($id);
        return view('admin.post.update', compact('list_post_cat', 'post'));
    }

    public function update(PostUpdateRequest $request, $id)
    {
        $input = $request->except('_token');
        if ($request->hasFile('post_thumb')) {
            $file = $request->post_thumb;
            $file->getCLientOriginalName();
            $file->move('public/upload/post/', $file->getClientOriginalName());
            $input['post_thumb'] = "/upload/post/" . $file->getClientOriginalName();
        }
        $input['slug'] = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($request->input('post_title'));
        Post::withTrashed()->where('id',$id)->update($input);
        return redirect(Route('admin.post.index'))->with('alert', 'Cập nhật bài viết thành công');
    }

    function destroy($id)
    {
        Post::destroy($id);
        return redirect(Route('admin.post.index'))->with('alert', 'Xóa bài viết thành công');
    }

    function delete($id)
    {
        Post::where('id',$id)->forceDelete();
        return redirect(Route('admin.post.index'))->with('alert', 'Xóa bài viết thành công');
    }
}
