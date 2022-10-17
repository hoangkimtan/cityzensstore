<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\ProductCat;
use App\Product;
use App\OrderDetail;
use App\Page;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current', $tables);
        if (in_array('products', $tables) && in_array('order_product', $tables) && in_array('product_cats', $tables) && in_array('pages', $tables)  && in_array('orders', $tables)) {
            $list_best_sell_id = OrderDetail::selectRaw("sum(qty) as num_qty, product_id")
                ->join('orders', 'order_product.order_id', '=', 'orders.id')
                ->where('status', '=', 'completed')
                ->groupBy('product_id')
                ->orderBy('num_qty', 'DESC')
                ->limit(8)
                ->get();
            $data = array();
            foreach ($list_best_sell_id as $item) {
                $data[] = $item->product_id;
            }
            $list_best_sell = Product::whereIn('id', $data)->where('status', '=', 'publish')->limit(8)->get();
            $list_cat = ProductCat::all();
            $list_cats = ProductCat::all();
            $list_page_header = Page::where([['page_cat', '=', 'header'], ['status', '=', 'publish']])->get();
            $list_page_footer = Page::where([['page_cat', '=', 'footer'], ['status', '=', 'publish']])->get();
            View::share(compact('list_cat', 'list_best_sell', 'list_cats', 'list_page_header', 'list_page_footer'));
        }
    }
}
