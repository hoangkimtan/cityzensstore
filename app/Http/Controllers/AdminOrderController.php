<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Product;
use App\OrderDetail;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'pending' => 'Chờ duyệt',
            'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang vận chuyển',
            'completed' => 'Thành công',
            'cancel' => 'Hủy',
            'trash' => 'Bỏ vào thùng rác'
        ];

        if ($status == "") {
            $list_order = Order::orderBy('id', 'DESC')->paginate(10);
            $list_order->appends(['status' => $status]);
        }

        if ($status == "success") {
            $list_act = [];
            $list_order = Order::where('status', '=', 'completed')->orderBy('id', 'DESC')->paginate(10);
            $list_order->appends(['status' => $status]);
        }

        if ($status == "pending") {
            $list_order = Order::where('status', '=', 'pending')->orderBy('id', 'DESC')->paginate(10);
            $list_order->appends(['status' => $status]);
        }

        if ($status == "shipping") {
            $list_order = Order::where('status', '=', 'shipping')->orderBy('id', 'DESC')->paginate(10);
            $list_order->appends(['status' => $status]);
        }

        if ($status == "cancel") {
            $list_act = [
                'trash' => 'Bỏ vào thùng rác',
                'delete' => 'Xóa vĩnh viễn',
            ];
            $list_order = Order::where('status', '=', 'cancel')->orderBy('id', 'DESC')->paginate(10);
            $list_order->appends(['status' => $status]);
        }

        if ($status == "trash") {
            $list_act = [
                'restore' => 'Khôi phục',
                'delete' => 'Xóa vĩnh viễn',

            ];
            $list_order = Order::onlyTrashed()->orderBy('id', 'DESC')->paginate(10);
            $list_order->appends(['status' => $status]);
        }

        if ($request->input('key')) {
            $key = $request->input('key');
            $list_order = Order::where('fullname', 'LIKE', "%{$key}%")
                ->orWhere('phone', 'LIKE', "%{$key}%")
                ->orWhere('orderCode', 'LIKE', "%{$key}%")
                ->paginate(15);
            $list_order->appends('key', $key);
        }
        $list_order_all = Order::count();
        $list_order_completed = Order::where('status', '=', 'completed')->count();
        $list_order_pending = Order::where('status', '=', 'pending')->count();
        $list_order_shipping = Order::where('status', '=', 'shipping')->count();
        $list_order_cancel = Order::where('status', '=', 'cancel')->count();
        $list_order_trash = Order::onlyTrashed()->count();
        $count = array($list_order_all, $list_order_completed, $list_order_pending, $list_order_cancel, $list_order_trash, $list_order_shipping);
        return view('admin.order.index', compact('list_order', 'count', 'list_act'));
    }

    public function edit(Request $request, $id)
    {
        $detail = Order::withTrashed()->where('id', $id)->first();
        $list_order_product = OrderDetail::where('order_id', $id)->get();
        return view('admin.order.detail', compact('detail', 'list_order_product'));
    }

    function update(OrderUpdateRequest $request, $id)
    {
        $info_order = Order::withTrashed()->where('id', $id)->first();
        $status = $request->input('status');
        if ($info_order->status == 'completed') {
            return redirect()->back()->with('alert', 'Đơn hàng ở trạng thái thành công không thể cập nhật trạng thái');
        } elseif ($info_order->status == 'cancel') {
            return redirect()->back()->with('alert', 'Đơn hàng ở trạng thái hủy không thể cập nhật trạng thái');
        } else {
            Order::withTrashed()->where('id', $id)->update($request->except('_token'));
            if ($status == "completed") {
                $list_order_detail =  OrderDetail::where('order_id', $id)->get();
                foreach ($list_order_detail as $item) {
                    $product = Product::where('id', $item->product_id)->first();
                    Product::where('id', $item->product_id)->update([
                        'qty' => $product->qty - $item->qty
                    ]);
                    $product = Product::where('id', $item->product_id)->first();
                    if ($product->qty <= 0) {
                        Product::where('id', $item->product_id)->update([
                            'tracking' => 'out-of-stock'
                        ]);
                    }
                }
            }
            return redirect()->back()->with('alert', 'Cập nhật thành công');
        }
    }

    public function destroy($id)
    {
        Order::destroy($id);
        return redirect()->back()->with('alert', 'Bỏ vào thùng rác thành công');
    }

    public function delete($id)
    {
        Order::where('id', $id)->forceDelete();
        return redirect()->back()->with('alert', 'Xoá thành công');
    }

    public function action(Request $request)
    {
        $action = $request->input('action');
        if ($request->input('list_check')) {
            $list_check = $request->input('list_check');
            if ($action) {
                $list_order = Order::whereIn('id', $list_check)->get();
                foreach ($list_order as $item) {
                    if ($item->status == 'completed') {
                        return redirect()->back()->with('alert', 'Đơn hàng ở trạng thái thành công không thể thay đổi trạng thái');
                    }

                    if ($item->status == 'cancel') {
                        if ($action == "trash") {
                            Order::destroy($list_check);
                            return redirect()->back()->with('alert', 'Bỏ vào thùng rác thành công');
                        }

                        if ($action == "restore") {
                            Order::whereIn('id', $list_check)->restore();
                            return redirect()->back()->with('alert', 'Khôi phục thành công');
                        }

                        if ($action == "delete") {
                            Order::whereIn('id', $list_check)->forceDelete();
                            return redirect()->back()->with('alert', 'Xóa vĩnh viễn thành công');
                        }
                        return redirect()->back()->with('alert', 'Đơn hàng ở trạng thái hủy không thể thay đổi trạng thái');
                    }
                }

                if ($action == "pending") {
                    Order::whereIn('id', $list_check)->update([
                        'status' => 'pending'
                    ]);
                    return redirect()->back()->with('alert', 'Cập nhật thành công');
                }

                if ($action == "shipping") {
                    Order::whereIn('id', $list_check)->update([
                        'status' => 'shipping'
                    ]);
                    return redirect()->back()->with('alert', 'Cập nhật thành công');
                }

                if ($action == "confirmed") {
                    Order::whereIn('id', $list_check)->update([
                        'status' => 'confirmed'
                    ]);
                    return redirect()->back()->with('alert', 'Cập nhật thành công');
                }

                if ($action == "completed") {
                    DB::transaction(function () use ($list_check) {
                        Order::whereIn('id', $list_check)->update([
                            'status' => 'completed'
                        ]);
                        $list_order_detail =  OrderDetail::where('order_id', $list_check)->get();
                        foreach ($list_order_detail as $item) {
                            $product = Product::where('id', $item->product_id)->first();
                            Product::where('id', $item->product_id)->update([
                                'qty' => $product->qty - $item->qty
                            ]);
                            $product = Product::where('id', $item->product_id)->first();
                            if ($product->qty <= 0) {
                                Product::where('id', $item->product_id)->update([
                                    'tracking' => 'out-of-stock'
                                ]);
                            }
                        }
                    });

                    return redirect()->back()->with('alert', 'Cập nhật thành công');
                }

                if ($action == "cancel") {
                    Order::whereIn('id', $list_check)->update([
                        'status' => 'cancel'
                    ]);

                    foreach ($list_check as $item) {
                        $data = OrderDetail::where('order_id', $item)->get();
                    }

                    foreach ($data as $item) {
                        $product = Product::find($item->product_id);
                        Product::where('id', $item->product_id)->update([
                            'qty' =>  $product->qty + $item->qty
                        ]);
                    }

                    return redirect()->back()->with('alert', 'Cập nhật thành công');
                }

                if ($action == "trash") {
                    Order::destroy($list_check);
                    return redirect()->back()->with('alert', 'Bỏ vào thùng rác thành công');
                }

                if ($action == "restore") {
                    Order::whereIn('id', $list_check)->restore();
                    return redirect()->back()->with('alert', 'Khôi phục thành công');
                }

                if ($action == "delete") {
                    Order::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect()->back()->with('alert', 'Xóa vĩnh viễn thành công');
                }
            } else {
                return redirect()->back()->with('alert', 'Bạn chưa chọn hành động nào');
            }
        } else {
            return redirect()->back()->with('alert', 'Bạn chưa chọn bản ghi nào');
        }
    }
}
