<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ProductCat;
use App\Product;
use App\Img;

class AdminProductController extends Controller
{

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function index(Request $request)
    {
        $status = $request->input('status');
        $key = "";
        $list_act = [
            'publish' => 'Xuất bản',
            'pending' => 'Chờ duyệt',
            'trash' => 'Xóa tạm thời',
        ];

        if ($status == "") {
            $list_product = Product::orderBy('id','desc')->paginate(10);
            $list_product->appends(['status' => $status]);
        }

        if ($status == "publish") {
            $list_product = Product::where('status', '=', 'publish')->paginate(10);
            $list_product->appends(['status' => $status]);
        }

        if ($status == "out-of-stock") {
            $list_product = Product::where('tracking', '=', 'out-of-stock')->paginate(10);
            $list_product->appends(['status' => $status]);
        }

        if ($status == "pending") {
            $list_product = Product::where('status', '=', 'pending')->paginate(10);
            $list_product->appends(['status' => $status]);
            $list_act = [
                'publish' => 'Xuất bản',
                'trash' => 'Xóa tạm thời',
            ];
        }

        if ($status == "trash") {
            $list_product = Product::onlyTrashed()->paginate(10);
            $list_product->appends(['status' => $status]);
            $list_act = [
                'restore' => 'Khôi phục',
                'delete' => 'Xóa vĩnh viễn',
            ];
        }

        if ($request->input('key')) {
            $key = $request->input('key');
            $list_product = Product::where('product_title', "LIKE", "%{$key}%")->paginate(10);
            $list_product->appends(['key' => $key]);
        }

        $num_all = Product::count();
        $num_publish = Product::where('status', '=', 'publish')->count();
        $num_pending = Product::where('status', '=', 'pending')->count();
        $num_trash = Product::onlyTrashed()->count();
        $out_of_stock = Product::where('tracking', '=', 'out-of-stock')->count();
        $count = array($num_all, $num_publish, $num_pending, $num_trash, $out_of_stock);
        return view('admin.product.index', compact('list_product', 'list_act', 'count'));
    }

    function create()
    {
        $list_product_cat = ProductCat::all();
        $list_product_cat = data_tree($list_product_cat);
        return view('admin.product.add', compact('list_product_cat'));
    }

    function store(ProductStoreRequest $request)
    {
        $data = $request->all();
        $data['slug'] =  Str::slug($request->input('product_title'));
        $data['code'] = !empty($request->input('code')) ?  $request->input('code') : "CITYZENS-" . Str::upper(Str::random(6));
        $data['feature'] = !empty($request->input('feature')) ?  $request->input('feature') : "0";
        if ($request->hasFile('product_thumb')) {
            $file = $request->product_thumb;
            $file->getCLientOriginalName();
            $file->move('public/upload/product/', $file->getClientOriginalName());
            $data['product_thumb'] = "upload/product/" . $file->getClientOriginalName();
        }

        $id = Product::create($data)->id;
        if ($request->hasFile('product_thumb_relative')) {
            $files = $request->product_thumb_relative;
            $data = array();
            foreach ($files as $file) {
                $img = new Img();
                $img->img_relative_thumb = 'upload/product/' . $file->getClientOriginalName();
                $img->product_id = $id;
                $file->move('public/upload/product/', $file->getClientOriginalName());
                $img->save();
            }
        }
        return redirect(Route('admin.product.index'))->with('alert', 'Thêm sản phẩm thành công');
    }

    function destroy($id)
    {
        Product::destroy($id);
        return redirect()->back()->with("alert", "Xóa tạm thời thành công");
    }

    function delete($id)
    {
        Product::where('id',$id)->forceDelete();
        return redirect()->back()->with("alert", "Xóa thành công");
    }

    function edit($id)
    {
        $list_product_cat = ProductCat::all();
        $list_product_cat = data_tree($list_product_cat);
        $product = Product::withTrashed()->where('id',$id)->first();
        $list_img = Img::where('product_id', $id)->get();
        return view('admin.product.update', compact('list_product_cat', 'product', 'list_img'));
    }

    function update(ProductUpdateRequest $request, $id)
    {
        $data = $request->except('_token','product_thumb_old','btn_update', 'product_thumb_relative');
        $data['slug'] = Str::slug($request->product_title);
        if ($data['qty'] <= 0) {
            $data['tracking'] = 'out-of-stock';
        } else {
            $data['tracking'] = 'stocking';
        }
        if ($request->hasFile('product_thumb')) {
            $file = $request->product_thumb;
            $file->getCLientOriginalName();
            $file->move('public/upload/product/', $file->getClientOriginalName());
            $data['product_thumb'] = "upload/product/" . $file->getClientOriginalName();
        }

        if ($request->hasFile('product_thumb_relative')) {
            $files = $request->product_thumb_relative;
            Img::where('product_id', $id)->delete();
            foreach ($files as $file) {
                $img = new Img();
                $img->img_relative_thumb = 'upload/product/' . $file->getClientOriginalName();
                $img->product_id = $id;
                $file->move('public/upload/product/', $file->getClientOriginalName());
                $img->save();
            }
        }
        Product::withTrashed()->where('id',$id)->update($data);
        return redirect()->back()->with('alert', 'Cập nhật thành công');
    }

    function action(Request $request)
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
                Product::whereIn('id', $list_check)->update([
                    'status' => "pending"
                ]);
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }

            if ($action == "trash") {
                Product::destroy($list_check);
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }

            if ($action == "delete") {
                Product::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }

            if ($action == "restore") {
                Product::whereIn('id', $list_check)->restore();
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }

            if ($action == "publish") {
                Product::whereIn('id', $list_check)->update([
                    'status' => "publish"
                ]);
                return redirect()->back()->with('alert', 'Cập nhật thành công');
            }
        }
    }
}
