<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\PageStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Page;

class AdminPageController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $key = "";
        $list_act = [
            'publish' => 'Xuất bản',
            'pending' => 'Chờ duyệt',
        ];
        if ($status == "publish") {
            $list_page = Page::where('status', '=', 'publish')->paginate(10);
            $list_page->appends(['status' => $status]);
        }
        if ($status == "pending") {
            $list_page = Page::where('status', '=', 'pending')->paginate(10);
            $list_page->appends(['status' => $status]);
        }
        if ($status == "") {
            $list_page = Page::orderBy('id','desc')->paginate(10);
            $list_page->appends(['status' => $status]);
        }
        $num_all = Page::count();
        $num_publish = Page::where('status', '=', 'publish')->count();
        $num_pending = Page::where('status', '=', 'pending')->count();
        $count = array($num_all, $num_publish, $num_pending);
        return view('admin.page.index', compact('list_page', 'list_act', 'count'));
    }

    public function create()
    {
        return view('admin.page.add');
    }

    public function store(PageStoreRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->input('page_title'));
        Page::create($data);
        return redirect(Route('admin.page.index'))->with('alert', 'Thêm thành công');
    }

    public function edit($id)
    {
        $page = Page::find($id);
        return view('admin.page.update', compact('page'));
    }

    public function update(PageStoreRequest $request, $id)
    {
        $data = $request->all();
        Page::find($id)->update($data);
        return redirect(Route('admin.page.index'))->with('alert', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        Page::destroy($id);
        return redirect()->back()->with('alert', 'Xóa trang thành công');
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        $action = $request->input('action');

        if (!$list_check) {
            return redirect()->back()->with('alert', 'Bạn chưa chọn bản ghi nào');
        } else {
            if ($action == '') {
                return redirect()->back()->with('alert', 'Bạn chưa chọn hành động nào');
            }

            if ($action == "pending") {
                Page::whereIn('id', $list_check)->update([
                    'status' => "pending"
                ]);
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }

            if ($action == "publish") {
                Page::whereIn('id', $list_check)->update([
                    'status' => "publish"
                ]);
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }
        }
    }
}
