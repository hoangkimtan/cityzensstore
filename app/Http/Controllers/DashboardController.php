<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Post;
use App\Product;
use App\Slider;
use Carbon\Carbon;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dasboard']);
            return $next($request);
        });
    }

    public function show()
    {

        $list_order = Order::where('status', '=', 'pending')->orderBy('id', 'DESC')->paginate(10);
        $list_order_completed = Order::where('status', '=', 'completed')->count();
        $list_order_pending = Order::where('status', '=', 'pending')->count();
        $list_order_cancel = Order::where('status', '=', 'cancel')->count();
        $list_order_shipping = Order::where('status', '=', 'shipping')->count();
        $list_posts = Post::count();
        $list_products = Product::count();
        $list_sliders = Slider::count();
        $count = array($list_order_completed, $list_order_pending, $list_order_cancel,$list_order_shipping,$list_posts,$list_products,$list_sliders);
        $sales = Order::where('status', '=', 'completed')->sum('total');
        return view('admin.dashboard', compact('list_order', 'count', 'sales'));
    }

    public function statistical(Request $request)
    {
        $first_day_of_month = Carbon::now()->startOfMonth();
        $last_day_of_month = Carbon::now()->endOfMonth();
        $statistical = Order::where('status', 'completed')
            ->whereBetween('created_at',  [$first_day_of_month, $last_day_of_month])
            ->groupBy('date')
            ->selectRaw("sum(total) as total")
            ->selectRaw("DATE(created_at) as date")
            ->get();
        $data_chart = array();
        foreach ($statistical as $key => $item) {
            $data_chart[] = array(
                'date' => Carbon::parse($item->date)->format('d-m-Y'),
                'total' => $item->total,
            );
        }
        echo $data = json_encode($data_chart);
    }

    public function filter_date(Request $request)
    {
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d 23:59:59');
        $statistical = Order::where('status', 'completed')
            ->whereBetween('created_at',  [$from_date, $to_date])
            ->groupBy('date')
            ->selectRaw("sum(total) as total")
            ->selectRaw("DATE(created_at) as date")
            ->get();
        foreach ($statistical as $key => $item) {
            $data_chart[] = array(
                'date' => Carbon::parse($item->date)->format('d-m-Y'),
                'total' => $item->total,
            );
        }
        $data = array(
            'data_chart' => $data_chart,
            'message' => 1,
        );
        echo json_encode($data);
    }
}
