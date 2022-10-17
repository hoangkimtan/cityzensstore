<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Order;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'customer']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $list_customer = Customer::orderBy('id', 'desc')->paginate(10);
        if ($request->input('key')) {
            $key = $request->input('key');
            $list_customer = Customer::where('fullname', 'LIKE', "%{$key}%")->orWhere('phone', 'LIKE', "%{$key}%")->paginate(10);
            $list_customer->appends('key', $key);
        }
        return view('admin.customer.index', compact('list_customer'));
    }

    public function show(Request $request, $id)
    {
           $customer = Customer::find($id);
        if ($customer) {
            $orders = Customer::find($id)->orders()->paginate(10);
        } else {
            $orders = null;
        }
        return view('admin.customer.detail', compact('customer', 'orders'));
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        Customer::find($id)->update($request->all());
        // Order::where('customer_id', $id)->update([
        //     'phone' => $request->phone
        // ]);
        return redirect()->back()->with('alert', 'Cập nhật thông tin khách hàng thành công');
    }

    public function destroy($id)
    {
        Customer::destroy($id);
        return redirect()->back()->with('alert', 'Xóa khách hàng thành công');
    }
}
