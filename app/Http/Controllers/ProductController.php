<?php

namespace App\Http\Controllers;

use App\Img;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\ProductCat;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list(Request $request, $slug, $id)
    {
        $request->session()->put('action', 'listProduct');
        $list_cat = ProductCat::all();
        $list_trademark = cat_filter($list_cat, $id);
        $list_breadcrumbs = get_breadcrumb($list_cat, $id);
        $list_breadcrumbs = (array_reverse($list_breadcrumbs));
        $list_cat = data_tree($list_cat, $id, 0);
        $cat = ProductCat::where('id', $id)->first();
        $data = array();
        $data[] = $id;
        foreach ($list_cat as $item) {
            $data[] = $item->id;
        }
        $list_product = Product::whereIn('product_cat_id', $data)->where('status', '=', 'publish')->paginate(8);
        return view('product.product_list', compact('cat', 'list_product', 'list_breadcrumbs', 'list_trademark'));
    }

    public function detail($slug, $id)
    {
        $product = Product::where('status', 'publish')->find($id);
        $list_cat = ProductCat::all();
        $list_img = Img::where('product_id', $id)->get();
        if ($product) {
            $list_breadcrumbs = get_breadcrumb($list_cat, $product->product_cat_id);
            $list_breadcrumbs = (array_reverse($list_breadcrumbs));
            $list_product_same = Product::where([['product_cat_id', '=', $product->product_cat_id], ['tracking', '=', 'stocking']])->where('id', '!=', $id)->get();
            return view('product.product_detail', compact('product', 'list_img', 'list_breadcrumbs', 'list_product_same'));
        }
        return view('product.product_detail', compact('product', 'list_img'));

    }

    public function search(Request $request)
    {
        $key = $request->input('key');
        if ($key == '') {
            return redirect(url('/'));
        }
        $list_cat = ProductCat::all();
        $request->session()->put('action', 'search');
        $list_product = Product::where('product_title', 'LIKE', "%{$key}%")->paginate(15);
        $list_product->appends(['key' => $key]);
        return view('product.product_list', compact('list_product'));
    }

    public function filterPrice()
    {
        $price = $_GET['price'];
        $brand = $_GET['brand'];
        $id = $_GET['id'];
        $list_cat = ProductCat::all();
        $list_child = data_tree($list_cat, $id);
        $data = array();
        $data[] = $id;
        foreach ($list_child as $item) {
            $data[] = $item->id;
        }
        if ($brand == null) {
            if ($price == 1) {
                $list_product = Product::where([['price', '<', '1000000'], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->whereIn('product_cat_id', $data)->get();
            }
            if ($price == 2) {
                $list_product = Product::where([['price', '>=', '1000000'], ['price', '<=', '5000000'], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->whereIn('product_cat_id', $data)->get();
            }
            if ($price == 3) {
                $list_product = Product::where([['price', '>=', '5000000'], ['price', '<=', '10000000'], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->whereIn('product_cat_id', $data)->get();
            }
            if ($price == 4) {
                $list_product = Product::where([['price', '>', '10000000'], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->whereIn('product_cat_id', $data)->get();
            }
        } else {
            if ($price == 1) {
                $list_product = Product::where([['price', '<', '1000000'], ['product_cat_id', '=', $brand], ['tracking', '=', 'stocking']])->get();
            }
            if ($price == 2) {
                $list_product = Product::where([['price', '>=', '1000000'], ['price', '<=', '5000000'], ['product_cat_id', '=', $brand], ['tracking', '=', 'stocking']])->get();
            }
            if ($price == 3) {
                $list_product = Product::where([['price', '>=', '5000000'], ['price', '<=', '10000000'], ['product_cat_id', '=', $brand], ['tracking', '=', 'stocking']])->get();
            }
            if ($price == 4) {
                $list_product = Product::where([['price', '>=', '10000000'], ['product_cat_id', '=', $brand], ['tracking', '=', 'stocking']])->get();
            }
        }
        $count = $list_product->count();
        $str = "";
        if ($count > 0) {
            $str = "<ul class='list-item clearfix'>";
            foreach ($list_product as $item) {
                $slug_title = create_slug($item->product_title);
                $route_product = (Route('product.detail', [$slug_title, $item->id]));
                $route_add_cart = Route('cart.get.add', $item->id);
                $route_buy_now = Route('cart.buynow', $item->id);
                $price = currency_format($item->price, '.đ');
                $product_thumb = asset($item->product_thumb);
                $str .= "<li>
                <div class='img'>
                    <a href='{$route_product}' title=''
                        class='thumb'>
                        <img src='{$product_thumb}' class='img-fluid'>
                    </a>
                </div>
                <a href='{$route_product}' title=''
                    class='product-name'> {$item['product_title']} </a>
                <div class='price'>
                    <span class='new'>{$price}</span>
                </div>
                <div class='action clearfix'>
                    <a href='{$route_add_cart}' title='Thêm giỏ hàng'
                        class='add-cart fl-left'>Thêm giỏ hàng</a>
                    <a href='{$route_buy_now}' title='Mua ngay'
                        class='buy-now fl-right'>Mua ngay</a>
                </div>
            </li>";
            }
            $str .= "</ul>";
        } else {
            $noti_search = asset('images/noti-search.png');
            $str .= "<div class='notification'>
            <span class='d-block'>
            <img class='img-fluid d-inline-block' src='{$noti_search}'>
            </span>
            <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn Vui lòng thử lại .</p>
            </div>";
        }
        $pagging = "";
        $data = array(
            'str' => $str,
            'count' => "({$count} sản phẩm)",
            'pagging' => $pagging,
            'data' => $data

        );
        echo json_encode($data);
    }

    public function filterBrand()
    {
        $price = $_GET['price'];
        $brand = $_GET['brand'];
        $info_cat_title = ProductCat::find($brand)->product_cat_title;
        if ($price == null) {
            $list_product = Product::where('product_cat_id', $brand)->where([['status', '=', 'publish'], ['tracking', '=', 'stocking']])->get();
        } else {
            if ($price == 1) {
                $list_product = Product::where([['price', '<', '1000000'], ['product_cat_id', '=', $brand], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->get();
            }
            if ($price == 2) {
                $list_product = Product::where([['price', '>=', '1000000'], ['price', '<=', '5000000'], ['product_cat_id', '=', $brand], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->get();
            }
            if ($price == 3) {
                $list_product = Product::where([['price', '>=', '5000000'], ['price', '<=', '10000000'], ['product_cat_id', '=', $brand], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->get();
            }
            if ($price == 4) {
                $list_product = Product::where([['price', '>=', '10000000'], ['product_cat_id', '=', $brand], ['status', '=', 'publish'], ['tracking', '=', 'stocking']])->get();
            }
        }
        $count = $list_product->count();
        $str = "";
        if ($count > 0) {
            $str = "<ul class='list-item clearfix'>";
            foreach ($list_product as $item) {
                $slug_title = create_slug($item->product_title);
                $route_product = (Route('product.detail', [$slug_title, $item->id]));
                $route_add_cart = Route('cart.get.add', $item->id);
                $route_buy_now = Route('cart.buynow', $item->id);
                $price = currency_format($item->price, '.đ');
                $product_thumb = asset($item->product_thumb);
                $str .= "<li>
                <div class='img'>
                    <a href='{$route_product}' title=''
                        class='thumb'>
                        <img src='{$product_thumb}' class='img-fluid'>
                    </a>
                </div>
                <a href='{$route_product}' title=''
                    class='product-name'> {$item['product_title']} </a>
                <div class='price'>
                    <span class='new'>{$price}</span>
                </div>
                <div class='action clearfix'>
                    <a href='{$route_add_cart}' title='Thêm giỏ hàng'
                        class='add-cart fl-left'>Thêm giỏ hàng</a>
                    <a href='{$route_buy_now}' title='Mua ngay'
                        class='buy-now fl-right'>Mua ngay</a>
                </div>
            </li>";
            }
            $str .= "</ul>";
        } else {
            $noti_search = asset('images/noti-search.png');
            $str .= "<div class='notification'>
            <span class='d-block'>
            <img class='img-fluid d-inline-block' src='{$noti_search}'>
            </span>
            <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn Vui lòng thử lại .</p>
            </div>";
        }
        $pagging = "";
        $data = array(
            'str' => $str,
            'count' => "Hiển thị {$count} sản phẩm",
            'pagging' => $pagging,
            'cat_title' => $info_cat_title
        );
        echo json_encode($data);
    }

    public function sort()
    {
        $value = $_GET['value'];
        $id = $_GET['id'];
        $list_cat = ProductCat::all();
        $list_cat = data_tree($list_cat, $id);
        $data = [];
        $data[] = $id;
        foreach ($list_cat as $item) {
            $data[] = $item->id;
        }
        if (isset($_GET['price'])) {
            $price = $_GET['price'];
        }
        if (isset($_GET['brand'])) {
            $brand = $_GET['brand'];
        }
        $list_product = Product::where('status', '=', 'publish');
        if ($value == 1) {
            if (isset($price)) {
                if ($price == 1) {
                    $list_product->where('price', '<', '1000000');
                }
                if ($price == 2) {
                    $list_product->whereBetween('price', [1000000, 5000000]);
                }
                if ($price == 3) {
                    $list_product->whereBetween('price', [5000000, 10000000]);
                }
                if ($price == 4) {
                    $list_product->where('price', '>', '10000000');
                }
            }
            if (isset($brand)) {
                $list_product->where('product_cat_id', $brand);
            } else {
                $list_product->whereIn('product_cat_id', $data);
            }
            $list_product = $list_product->where('tracking', '=', 'stocking')->orderBy('price', 'DESC')->get();
        } elseif ($value == 2 or $value == 0) {
            if (isset($price)) {
                if ($price == 1) {
                    $list_product->where('price', '<', '1000000');
                }
                if ($price == 2) {
                    $list_product->whereBetween('price', [1000000, 5000000]);
                }
                if ($price == 3) {
                    $list_product->whereBetween('price', [5000000, 10000000]);
                }
                if ($price == 4) {
                    $list_product->where('price', '>', '10000000');
                }
            }
            if (isset($brand)) {
                $list_product->where('product_cat_id', $brand);
            } else {
                $list_product->whereIn('product_cat_id', $data);
            }
            $list_product = $list_product->orderBy('price', 'ASC')->get();
        }
        $count = $list_product->count();
        $str = "";
        if ($count > 0) {
            $str = "<ul class='list-item clearfix'>";
            foreach ($list_product as $item) {
                $slug_title = create_slug($item->product_title);
                $route_product = (Route('product.detail', [$slug_title, $item->id]));
                $route_add_cart = Route('cart.get.add', $item->id);
                $route_buy_now = Route('cart.buynow', $item->id);
                $price = currency_format($item->price, '.đ');
                $product_thumb = asset($item->product_thumb);
                $str .= "<li>
                <div class='img'>
                    <a href='{$route_product}' title=''class='thumb'>
                        <img src='{$product_thumb}' class='img-fluid'>
                    </a>
                </div>
                <a href='{$route_product}' title='' class='product-name'> {$item['product_title']} </a>
                <div class='price'>
                    <span class='new'>{$price}</span>
                </div>
                <div class='action clearfix'>
                    <a href='{$route_add_cart}' title='Thêm giỏ hàng'
                        class='add-cart fl-left'>Thêm giỏ hàng</a>
                    <a href='{$route_buy_now}' title='Mua ngay'
                        class='buy-now fl-right'>Mua ngay</a>
                </div>
            </li>";
            }
            $str .= "</ul>";
        } else {
            $noti_search = asset('images/noti-search.png');
            $str .= "<div class='notification'>
            <span class='d-block'>
            <img class='img-fluid d-inline-block' src='{$noti_search}'>
            </span>
            <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn Vui lòng thử lại .</p>
            </div>";
        }
        $pagging = "";
        $data = array(
            'str' => $str,
            'count' => "Hiển thị {$count} sản phẩm",
            'pagging' => $pagging,
        );
        echo json_encode($data);
    }
}
