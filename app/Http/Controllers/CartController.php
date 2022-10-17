<?php

namespace App\Http\Controllers;

use App\City;
use App\Commune;
use App\Customer;
use App\District;
use App\Http\Requests\Order\SubmitOrderRequest;
use App\Order;
use App\User;
use App\Product;
use App\OrderDetail;
use App\Mail\MailCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;
use GuzzleHttp\Client;


class CartController extends Controller
{
    public function show()
    {
        return view('cart.cart');
    }

    public function checkout()
    {
        $list_city = City::all();
        $list_district = District::all();
        $list_commune = Commune::all();
        return view('cart.checkout', compact('list_city', 'list_district', 'list_commune'));
    }

    public function success($orderCode)
    {
        $info_order = Order::where('orderCode', '=', $orderCode)->first();
        $list_order = OrderDetail::where('order_id', $info_order->id)->get();
        foreach ($list_order as $item) {
            $item['product_title'] = Product::find($item->product_id)->product_title;
            $item['product_thumb'] = Product::find($item->product_id)->product_thumb;
        }
        return view('cart.order_success', compact('info_order', 'list_order'));
    }

    public function postCheckout(SubmitOrderRequest $request)
    {
        $info_order = DB::transaction(function () use ($request) {
            $customer = Customer::where('phone', '=', $request->input('phone'))->first();
            if (empty($customer)) {
                $customer_id = Customer::create([
                    "fullname" => Str::title($request->input('fullname')),
                    "email" => $request->input('email'),
                    "phone" => $request->input('phone'),
                    "address" => $request->input('address') . "/" . $request->input('commune')  . "/" . $request->input('district') . "/" . $request->input('city'),
                ])->id;
            } else {
                Customer::where('phone', '=', $request->input('phone'))->update([
                    "fullname" => Str::title($request->input('fullname')),
                    "email" => $request->input('email'),
                    "address" => $request->input('address') . "/" . $request->input('commune')  . "/" . $request->input('district') . "/" . $request->input('city'),
                ]);
                $customer_id = Customer::where('phone', '=', $request->input('phone'))->first()->id;
            }

            $orderCode = "CITYZENS-" . Str::upper(Str::random(11));
            $order_id = Order::create([
                "fullname" => Str::title($request->input('fullname')),
                "orderCode" => $orderCode,
                "email" => $request->input('email'),
                "phone" => $request->input('phone'),
                "note" => $request->input('note'),
                "payment" => $request->input('payment_method'),
                "status" => 'pending',
                "total_product" => Cart::count(),
                "total" => Cart::total(),
                "customer_id" => $customer_id,
                "address" => $request->input('address') . "/" . $request->input('commune')  . "/" . $request->input('district') . "/" . $request->input('city'),
            ])->id;
            foreach (Cart::content() as $item) {
                OrderDetail::create([
                    'order_id' => $order_id,
                    'product_id' => $item->id,
                    'qty' => $item->qty,
                    'price' => $item->price
                ]);
            }
            $info_order = Order::find($order_id);
            return $info_order;
        });
        Cart::destroy();
        return redirect(Route('cart.order.success', $info_order->orderCode));
    }

    public function add(Request $request, $id)
    {
        $info_product = Product::find($id);
        if ($request->input('num_order')) {
            $qty = $request->input('num_order');
        } else {
            $qty = 1;
        }
        Cart::add([
            'id' => $id,
            'name' =>  $info_product->product_title,
            'qty' => $qty,
            'price' => $info_product->price,
            'options' => [
                'product_thumb' => $info_product->product_thumb,
                'code' => $info_product->code,
                'slug' => create_slug($info_product->product_title),
                'qty' => $info_product->qty
            ]
        ]);
        toastr()->success('Thêm giỏ hàng thành công');
        return redirect()->back();
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect()->back();
    }

    public function destroy()
    {
        Cart::destroy();
        return redirect()->back();
    }

    public function update()
    {
        $rowId = $_GET['rowId'];
        $qty = $_GET['qty'];
        Cart::update($rowId, $qty);
        $cart = Cart::content();
        $sub_total = currency_format($cart[$rowId]->total, '.đ');
        $num_order = $cart[$rowId]->qty;
        $total = currency_format(Cart::total(), '.đ');
        $total_cart = Cart::count();
        $data = array(
            'sub_total' => $sub_total,
            'total' => $total,
            'total_cart' => $total_cart,
            'num_order' => $num_order
        );
        echo json_encode($data);
    }

    public function buyNow(Request $request, $id)
    {
        $info_product = Product::find($id);
        if ($request->input('num_order')) {
            $qty = $request->input('num_order');
        } else {
            $qty = 1;
        }
        Cart::add([
            'id' => $id,
            'name' =>  $info_product->product_title,
            'qty' => $qty,
            'price' => $info_product->price,
            'options' => [
                'product_thumb' => $info_product->product_thumb,
                'code' => $info_product->code,
                'slug' => create_slug($info_product->product_title),
                'qty' => $info_product->qty
            ]
        ]);
        foreach (Cart::content() as $item) {
            $info_product = Product::find($item->id);
            if ($item->qty > $info_product->qty) {
                $item->qty = $info_product->qty;
                Cart::update($item->rowId, $item->qty);
            }
        };
        toastr()->success('Thêm giỏ hàng thành công');
        return redirect('thanh-toan');
    }

    public function getDistrict()
    {
        $str = "<option value=''>Chọn Quận Huyện</option>";
        if (isset($_GET['cityId']) && !empty($_GET['cityId'])) {
            $cityId = $_GET['cityId'];
            $list_district = District::where('matp', $cityId)->get();
            foreach ($list_district as $item) {
                $str .= "<option data-id='{$item['maqh']}' value='{$item['name']}'>{$item['name']}</option>";
            }
        }
        echo $str;
    }

    public function getCommune()
    {
        $str = "<option value=''>Chọn Phường Xã</option>";
        if (isset($_GET['districtId']) && !empty($_GET['districtId'])) {
            $districtId = $_GET['districtId'];
            $list_district = Commune::where('maqh', $districtId)->get();
            foreach ($list_district as $item) {
                $str .= "<option value='{$item['name']}'>{$item['name']}</option>";
            }
        }
        echo $str;
    }

    public function checkOrder(Request $request)
    {
        $order_code = $request->code;
        $info_order = Order::where('orderCode', $order_code)->first();
        $list_order_product = [];
        if ($info_order) {
            $list_order_product = OrderDetail::where('order_id', $info_order->id)->get();
        }
        return view('cart.check_order', compact('info_order', 'order_code', 'list_order_product'));
    }
}
