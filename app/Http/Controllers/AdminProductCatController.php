<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCat\ProductCatStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\ProductCat;
use Illuminate\Support\Facades\Gate;

class AdminProductCatController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product_cat']);

            return $next($request);
        });
    }

    function index()
    {
        $list_cat = ProductCat::all();
        $list_cat = data_tree($list_cat);
        return view('admin.product_cat.index', compact('list_cat'));
    }

    function store(ProductCatStoreRequest $request)
    {
        $post_cat_title = $request->input('product_cat_title');
        $slug = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($request->input('product_cat_title'));
        $parent_id = !empty($request->input('parent_id')) ? $request->input('parent_id') : '0';
        $data = array(
            'product_cat_title' => $post_cat_title,
            'slug' => $slug,
            'parent_id' => $parent_id,
        );
        ProductCat::create($data);
        return redirect(Route('admin.product_cat.index'))->with('alert', 'Thêm danh mục thành công');
    }

    function edit($id)
    {
        $list_cat = ProductCat::all();
        $list_cat = data_tree($list_cat);
        $cat = ProductCat::find($id);
        return view('admin.product_cat.update', compact('list_cat', 'cat'));
    }

    function update(ProductCatStoreRequest $request, $id)
    {
        $cat = ProductCat::find($id);
        $post_cat_title = $request->input('product_cat_title');
        $slug = !empty($request->input('slug')) ? Str::slug($request->input('slug')) : Str::slug($request->input('product_cat_title'));
        if ($request->input('parent_id') == $cat->id) {
            return redirect()->back()->with('alert', 'Không thể chọn danh mục này làm danh mục cha của chính nó');
        } else {
            $parent_id = !empty($request->input('parent_id')) ? $request->input('parent_id') : '0';
        }
        $data = array(
            'product_cat_title' => $post_cat_title,
            'slug' => $slug,
            'parent_id' => $parent_id,
        );
        ProductCat::where('id', $id)->update($data);
        return redirect(Route('admin.product_cat.index'))->with('alert', 'Cập nhật danh mục thành công');
    }

    function destroy($id)
    {
             $list_product_cat = ProductCat::all();
        $list_product_cat = data_tree($list_product_cat, $id);
        $ids = array_map(function ($item) {
            return $item->id;
        }, $list_product_cat);
        $ids[] = $id;
        ProductCat::whereIn('id', $ids)->delete();
        return redirect(Route('admin.product_cat.index'))->with('alert', 'Xóa danh mục thành công');
    }
}
