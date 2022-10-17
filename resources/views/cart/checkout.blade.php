@extends('layouts.home')
@section('content')
   <div class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ Route('cart.post.checkout') }}" name="form-checkout" id="form-checkout">
        @csrf
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Họ và tên" value="{{ old('fullname') }}"
                                id="fullname">
                            @error('fullname')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" id="email">
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Thành Phố</label>
                            <select name="city" id="city" data-url="{{ Route('checkout.get.district') }}"
                            class="form-control">
                                <option value="">Chọn Thành Phố</option>
                                @foreach ($list_city as $item)
                                    <option data-id="{{ $item->matp }}" value="{{ $item->name }}"
                                        @if (old('city') == $item->name) {{ 'selected' }} @endif>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-col fl-left">
                            <label for="address">Quận Huyện</label>
                            <select name="district" id="district" class="form-control" readonly style=" pointer-events: none;"  data-url="{{ Route('checkout.get.commune') }}">
                                <option value="">Chọn Quận Huyện</option>
                                @foreach ($list_district as $item)
                                    <option data-id="{{ $item->maqh }}" value="{{ $item->name }}"
                                        @if (old('district') == $item->name) {{ 'selected' }} @endif>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('district')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-col fl-left">
                            <label for="address">Phường Xã</label>
                            <select name="commune" id="commune" readonly style=" pointer-events: none;"  class="form-control">
                                <option value="">Chọn Phường Xã</option>
                                @foreach ($list_commune as $item)
                                <option data-id="{{ $item->xaid }}"  value="{{ $item->name }}"
                                    @if (old('commune') == $item->name) {{ 'selected' }} @endif>{{ $item->name }}
                                </option>
                            @endforeach
                            </select>
                            @error('commune')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-col fl-left" style="padding-right: 0">
                            <label for="address">Địa chỉ chi tiết</label>
                                <textarea name="address" id="address" class="form-control" placeholder="Số nhà, tên đường" id="address">{{ old('address') }}</textarea>
                            @error('address')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-col fl-left">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Số điện thoại"
                                id="phone">
                            @error('phone')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="notes">Ghi chú</label>
                            <textarea name="note" class="form-control" placeholder="Ghi chú nếu có">{{ old('note') }}</textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                                <tr class="cart-item">
                                    <td class="product-name">{{ $item->name }}<strong class="product-quantity">x
                                            {{ $item->qty }}</strong>
                                    </td>
                                    <td class="product-total">{{ currency_format($item->total, '.đ') }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Tổng đơn hàng:</td>
                                <td><strong class="total-price">{{ currency_format(Cart::total(), '.đ') }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment-checkout-wp">
                        <div class="accordion" id="accordion-pay">
                            <h5>Phương thức thanh toán</h5>
                            <div class="list-pay">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <a href="#pay-1" class="card-link d-block" style="line-height: 2px; color: #000">
                                            <input type="radio" name="payment_method" checked="" value="at-home"
                                                id="pay-cod">
                                            <label for="pay-cod">Thanh toán khi nhận hàng!</label>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        Vui lòng chú ý điện thoại chúng tôi sẽ tiến hàng xác nhận đơn hàng trong vòng
                                        <strong>48h</strong> và khi nhân viên giao hàng của chúng tôi giao sản phẩm đến tay
                                        quý khách, quý khách chỉ trả tiền khi nhận được đơn hàng
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header border-0">
                                        <a href="#pay-2" class="card-link d-block" style="line-height: 2px; color: #000">
                                            <input type="radio" name="payment_method" value="bank" id="pay-bank">
                                            <label for="pay-bank">Thanh toán ngân hàng</label>
                                        </a>
                                    </div>
                                    <div class="card-body" style="display: none;">
                                        <strong>TÀI KHOẢN 1:</strong> Nguyễn Sỹ Thái Hoàng <br>
                                        STK: 8300138575007 <br>
                                        Ngân hàng: MBank <br>
                                        <br>
                                        <strong>TÀI KHOẢN 2:</strong> Nguyễn Sỹ Thái Hoàng <br>
                                        STK: 0541000206151 <br>
                                        Ngân hàng: Vietcombank <br>
                                        <br>Thủ tục thanh toán trực tiếp tới ngân hàng: <br>
                                        1. Ghi chú chuyển khoản: <strong>Thanh toan don hang: #525232</strong> <br>
                                        2. Quý khách hàng sau khi bấm đặt hàng vui lòng đợi nhân viên xác nhận đặt hàng bằng
                                        cách gọi điện thoại thì mới tiến hành chuyển khoản<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="place-order-wp clearfix">
                        <input type="submit" id="order-now" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </div>
    </form>
   </div>
   <script>
       $(document).ready(function(){
           $("#form-checkout").submit(function(){
               $("#order-now").prop('disabled', true);
                 $("#order-now").css('cursor', 'not-allowed');
           })
       })
   </script>
@endsection
