@extends('layouts.home')
@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ url('/') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="" >Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="info-cart-wp">
                <div class="section-detail table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Mã sản phẩm</td>
                                <td>Ảnh sản phẩm</td>
                                <td style="width:350px">Tên sản phẩm</td>
                                <td>Giá sản phẩm</td>
                                <td>Số lượng</td>
                                <td colspan="2">Thành tiền</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Cart::count() > 0)
                                @foreach (Cart::content() as $item)
                                    <tr>
                                        <td>{{ $item->options->code }}</td>
                                        <td>
                                            <a href="{{ Route('product.detail', [$item->options->slug, $item->id]) }}"
                                                title="" class="thumb">
                                                <img src="{{ asset($item->options->product_thumb) }}" class="img-fluid"
                                                    alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ Route('product.detail', [$item->options->slug, $item->id]) }}"
                                                title="" class="name-product">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ currency_format($item->price, '.đ') }}</td>
                                        <td>
                                            <input type="number" data-url="{{ Route('cart.update') }}"
                                                data-rowId="{{ $item->rowId }}" name="num-order"
                                                value="{{ $item->qty }}" min="1" data-qty="{{$item->qty}}" class="num-order" id="num-order">
                                        </td>
                                        <td class="product-{{ $item->rowId }}">
                                            {{ currency_format($item->total, '.đ') }}</td>
                                        <td>
                                            <a href="{{ Route('cart.remove', $item->rowId) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa')"  title=""
                                                class="del-product"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Hiện không có sản phẩm nào trong giỏ hàng</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            @if (Cart::count() > 0)
                                <tr>
                                    <td colspan="1">
                                        <div class="clearfix">
                                            <p id="total-price" class="fl-left p-1">Tổng giá:
                                                <span>{{ currency_format(Cart::total(), '.đ') }}</span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                        <div class="clearfix">
                                            <div class="fl-left p-1">
                                                <a href="{{ Route('cart.checkout') }}" title="" id="checkout-cart">Thanh
                                                    toán</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="section" id="action-cart-wp">
                <div class="section-detail">
                    <a href="{{ url('/') }}" title="" id="buy-more">Mua tiếp</a><br />
                    <a href="{{ Route('cart.destroy') }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
@endsection

