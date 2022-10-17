@extends('layouts.home')
@section('content')
    <div id="content-wp" style="margin: 15px 20% 20px 20%;text-align: center;">
        <div class="d-inline-block">
            <img src="{{ asset('images/dau-check.png') }}" style="margin:0px auto" width="80px" alt="">
        </div>
        <p>Cảm ơn quý khách đã mua hàng tại Cityzens</p>
        <em>Quý khách có thể lưu mã đơn hàng và theo dõi thông tin đơn hàng của mình</em> <br>
        <em>Tổng đài viên Cityzens sẽ liên hệ đến quý khách trong vòng <strong>24 giờ </strong>để xác nhận đơn hàng</em>
        <em>xin cảm quý khách đã cho chúng tôi được phục vụ</em>
        <div class="widget mb-3" style="margin: 15px 20% 0px 20%;border: 1px solid #dee2e6;">
            <h4 class="wg-title"
                style="font-size: 16px;padding: 10px;text-align: left;border-bottom: 1px solid #dee2e6;">Thông tin đặt hàng
            </h4>
            <ul class="wg-content p-3">
                <li class="clearfix">
                    <span class="float-left">Mã đơn hàng</span>
                    <strong class="float-right">{{ $info_order->orderCode }}</strong>
                </li>
                <li class="clearfix">
                    <span class="float-left">Hình thức thanh toán</span>
                    <strong class="float-right"> {{ get_payment_method($info_order->payment) }}</strong>
                </li>
                <li class="clearfix">
                    <span class="float-left">Họ tên khách hàng</span>
                    <strong class="float-right">{{ $info_order->fullname }}</strong>
                </li>
                <li class="clearfix">
                    <span class="float-left">Số điện thoại</span>
                    <strong class="float-right">{{ $info_order->phone }}</strong>
                </li>
            </ul>
        </div>
        <div class="widget " style="margin: 15px 20% 10px 20%;border: 1px solid #dee2e6;border-bottom:none">
            <h4 class="wg-title"
                style="font-size:16px;padding: 10px;text-align: left;border-bottom: 1px solid #dee2e6;">
                Sản phẩm đã mua</h4>
            <ul class="wg-content p-3" style="border-bottom:none">
                @foreach ($list_order as $item)
                    <li class="clearfix mb-2" style="margin-bottom:2px;border-bottom:1px solid #dee2e6">
                        <img width="80px" class="float-left img-fluid img-order-success"
                            style="float: left; margin:5px auto" src=" {{ asset($item->product_thumb) }}" alt="">
                        <ul class="sub-wg-content" style="float:right; margin-left: 15px;width:75%">
                            <li style="margin-bottom: 5px;text-align: left;"><span
                                    style="text-align: left; width: 30%;">{{ $item->product_title }}</span>
                            </li>
                            <li style="margin-bottom: 5px; text-align: left"><span style="text-align: left; width: 40%;">Số
                                    lượng: {{ $item->qty }}</span>
                            </li>
                            <li style="margin-bottom: 5px;text-align: left"><span style="text-align: left; width: 40%;">Thành tiền: {{ currency_format(get_subtotal($item->price, $item->qty), '.đ') }}</span></li>
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="redirect">
            <a href="{{ url('/') }}" class="btn btn-outline-success" style="display: inline-block;padding: 15px;">Mua thêm sản phẩm khác</a>
        </div>
    </div>
@endsection
