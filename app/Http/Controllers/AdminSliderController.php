<?php

namespace App\Http\Controllers;

use App\Http\Requests\Slider\SliderStoreRequest;
use App\Http\Requests\Slider\SliderUpdateRequest;
use App\Slider;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $key = "";
        $list_act = [
            'pending' => 'Chờ duyệt',
            'publish' => 'Xuất bản',
        ];

        if ($status == "") {
            $list_slider = Slider::orderBy('id','desc')->paginate(10);
            $list_slider->appends(['status' => $status]);
        }
        if ($status == "publish") {
            $list_slider = Slider::where('status', '=', 'publish')->paginate(10);
            $list_slider->appends(['status' => $status]);
        }
        if ($status == "pending") {
            $list_slider = Slider::where('status', '=', 'pending')->paginate(10);
            $list_slider->appends(['status' => $status]);
        }
        $num_all = Slider::count();
        $num_publish = Slider::where('status', '=', 'publish')->count();
        $num_pending = Slider::where('status', '=', 'pending')->count();
        $count = array($num_all, $num_publish, $num_pending);
        return view('admin.slider.index', compact('list_slider', 'list_act', 'count'));
    }

    public function create()
    {
        return view('admin.slider.add');
    }

    public function store(SliderStoreRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('slider_thumb')) {
            $file = $request->slider_thumb;
            $file->getCLientOriginalName();
            $file->move('public/upload/slider/', $file->getClientOriginalName());
            $data['slider_thumb'] = "upload/slider/" . $file->getClientOriginalName();
        }
        Slider::create($data);
        return redirect()->back()->with('alert', 'Thêm slider thành công');
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.update', compact('slider'));
    }

    public function update(SliderUpdateRequest $request, $id)
    {
        $data = $request->all();
        if ($request->hasFile('slider_thumb')) {
            $file = $request->slider_thumb;
            $file->getCLientOriginalName();
            $file->move('public/upload/slider/', $file->getClientOriginalName());
            $data['slider_thumb'] = "upload/slider/" . $file->getClientOriginalName();
        }
        Slider::find($id)->update($data);
        return redirect()->back()->with('alert', 'Cập nhật slider thành công');
    }

    public function destroy($id)
    {
        Slider::destroy($id);
        return redirect()->back()->with('alert', 'Xóa slider thành công');
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
                Slider::whereIn('id', $list_check)->update([
                    'status' => "pending"
                ]);
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }

            if ($action == "publish") {
                Slider::whereIn('id', $list_check)->update([
                    'status' => "publish"
                ]);
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }
        }
    }
}
