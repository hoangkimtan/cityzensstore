<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCat;
use App\Product;
use App\Slider;
use App\Page;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $list_cat = ProductCat::all();
        $list_parent_0 = ProductCat::where('parent_id', 0)->get();
        $list_feature_product = Product::where([['feature', '=', 1], ['status', '=', 'publish']])->limit(10)->get();
        $list_slider = Slider::where('status', '=', 'publish')->orderBy('num_order', 'asc')->get();
        return view('home.home', compact('list_cat', 'list_feature_product', 'list_parent_0', 'list_slider'));
    }
}
