@extends('layouts.home')
@php
use App\ProductCat;
use App\Product;
@endphp
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="slider-wp">
            <div class="section-detail">
                @foreach ($list_slider as $item)
                    <div class="item" style="height:384px">
                        <img src="{{ asset($item->slider_thumb) }}" alt="" class="img-fluid">
                    </div>
                @endforeach
            </div>
        </div>
        {{-- <div class="section" id="support-wp">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <div class="thumb">
                            <img src="{{asset('images/icon-1.png')}}">
                        </div>
                        <h3 class="title">Miễn phí vận chuyển</h3>
                        <p class="desc">Tới tận tay khách hàng</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{asset('images/icon-2.png')}}">
                        </div>
                        <h3 class="title">Tư vấn 24/7</h3>
                        <p class="desc">1900.9999</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{asset('images/icon-3.png')}}">
                        </div>
                        <h3 class="title">Tiết kiệm hơn</h3>
                        <p class="desc">Với nhiều ưu đãi cực lớn</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{asset('images/icon-4.png')}}">
                        </div>
                        <h3 class="title">Thanh toán nhanh</h3>
                        <p class="desc">Hỗ trợ nhiều hình thức</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="{{asset('images/icon-5.png')}}">
                        </div>
                        <h3 class="title">Đặt hàng online</h3>
                        <p class="desc">Thao tác đơn giản</p>
                    </li>
                </ul>
            </div>
        </div> --}}
        @if ($list_feature_product->count() > 0)
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($list_feature_product as $product)
                            <li>
                                <a href="{{ Route('product.detail', [$product->slug, $product->id]) }}" title=""
                                    class="thumb thumb-effect">
                                    <img src="{{ asset($product->product_thumb) }}">
                                </a>
                                <a href="{{ Route('product.detail', [$product->slug, $product->id]) }}" title=""
                                    class="product-name">{{ $product->product_title }}</a>
                                <div class="price">
                                    <span class="new">{{ currency_format($product->price, '.đ') }}</span>
                                </div>
                                @if ($product->tracking == 'out-of-stock')
                                    <div class="sold-out">
                                        <img src="{{ asset('images/hethang.png') }}" alt="">
                                    </div>
                                @endif
                                <div class="action clearfix">
                                    @if ($product->tracking != 'out-of-stock')
                                        <a href="{{ Route('cart.get.add', $product->id) }}" title="Thêm giỏ hàng"
                                            class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ Route('cart.buynow', $product->id) }}" title="Mua ngay"
                                            class="buy-now fl-right">Mua
                                            ngay</a>
                                    @else
                                        <a href="{{ Route('cart.get.add', $product->id) }}" style="pointer-events: none"
                                            title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ Route('cart.buynow', $product->id) }}" style="pointer-events: none"
                                            title="Mua ngay" class="buy-now fl-right">Mua
                                            ngay</a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if ($list_best_sell->count() > 0)
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($list_best_sell as $product)
                            <li>
                                <a href="{{ Route('product.detail', [$product->slug, $product->id]) }}" title=""
                                    class="thumb thumb-effect">
                                    <img src="{{ asset($product->product_thumb) }}">
                                </a>
                                <a href="{{ Route('product.detail', [$product->slug, $product->id]) }}" title=""
                                    class="product-name">{{ $product->product_title }}</a>
                                <div class="price">
                                    <span class="new">{{ currency_format($product->price, '.đ') }}</span>
                                </div>
                                @if ($product->tracking == 'out-of-stock')
                                    <div class="sold-out">
                                        <img src="{{ asset('images/hethang.png') }}" alt="">
                                    </div>
                                @endif
                                <div class="action clearfix">
                                    @if ($product->tracking != 'out-of-stock')
                                        <a href="{{ Route('cart.get.add', $product->id) }}" title="Thêm giỏ hàng"
                                            class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ Route('cart.buynow', $product->id) }}" title="Mua ngay"
                                            class="buy-now fl-right">Mua
                                            ngay</a>
                                    @else
                                        <a href="{{ Route('cart.get.add', $product->id) }}" style="pointer-events: none"
                                            title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ Route('cart.buynow', $product->id) }}" style="pointer-events: none"
                                            title="Mua ngay" class="buy-now fl-right">Mua
                                            ngay</a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if ($list_parent_0)
            @foreach ($list_parent_0 as $item)
                @php
                    $data = [];
                    $list_product_cat = data_tree($list_cat, $item->id);
                    foreach ($list_product_cat as $item1) {
                        $data[] = $item1->id;
                    }
                    $data[] = $item->id;
                    $list_product = Product::whereIn('product_cat_id', $data)
                        ->where('status', '=', 'publish')
                        ->limit(8)
                        ->get();
                @endphp
                <div class="section" id="list-product-wp">
                    @if ($list_product->count() > 0)
                        <div class="section-head" style="display: flex;align-items: center;justify-content: space-between;">
                            <h3 class="section-title">{{ $item->product_cat_title }}</h3>
                            <a href="{{ Route('product.list', [$item->slug, $item->id]) }}"
                                style="margin: 40px 0px 20px 0px;">Xem tất cả</a>
                        </div>
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                @foreach ($list_product as $product)
                                    <li>
                                        <a href="{{ Route('product.detail', [$item->slug, $product->id]) }}" title=""
                                            class="thumb thumb-effect" style="">
                                            <img src="{{ asset($product->product_thumb) }}">
                                        </a>
                                        <a href="{{ Route('product.detail', [$item->slug, $product->id]) }}" title=""
                                            class="product-name">{{ $product->product_title }}</a>
                                        <div class="price">
                                            <span class="new">{{ currency_format($product->price, '.đ') }}</span>
                                        </div>
                                        @if ($product->tracking == 'out-of-stock')
                                            <div class="sold-out">
                                                <img src="{{ asset('images/hethang.png') }}" alt="">
                                            </div>
                                        @endif
                                        <div class="action clearfix">
                                            @if ($product->tracking != 'out-of-stock')
                                                <a href="{{ Route('cart.get.add', $product->id) }}" title="Thêm giỏ hàng"
                                                    class="add-cart fl-left">Thêm giỏ hàng</a>
                                                <a href="{{ Route('cart.buynow', $product->id) }}" title="Mua ngay"
                                                    class="buy-now fl-right">Mua
                                                    ngay</a>
                                            @else
                                                <a href="{{ Route('cart.get.add', $product->id) }}"
                                                    style="pointer-events: none" title="Thêm giỏ hàng"
                                                    class="add-cart fl-left">Thêm giỏ hàng</a>
                                                <a href="{{ Route('cart.buynow', $product->id) }}"
                                                    style="pointer-events: none" title="Mua ngay"
                                                    class="buy-now fl-right">Mua
                                                    ngay</a>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
@endsection

@section('section-sidebar')
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            {{ get_cat($list_cat) }}
        </div>
    </div>
    {{-- <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm bán chạy</h3>
        </div>
        @if ($list_best_sell->count() > 0)
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($list_best_sell as $item)
                        <li class="clearfix">
                            <a href="{{ Route('product.detail', [$item->slug, $item->id]) }}" title="" class="thumb fl-left">
                                <img src="{{ asset($item->product_thumb) }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ Route('product.detail', [$item->slug, $item->id]) }}" title=""
                                    class="product-name">{{ $item->product_title }}</a>
                                <div class="price">
                                    <span class="new">{{ currency_format($item->price, '.đ') }}</span>
                                </div>
                                <a href="{{ Route('product.detail', [$item->slug, $item->id]) }}" title="" class="buy-now">Xem chi tiết</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div> --}}
    <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="#" title="" class="thumb">
                <img src="{{ asset('images/banner.jpg') }}" alt="">
            </a>
        </div>
    </div>
    <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="#" title="" class="thumb">
                <img src="{{ asset('images/banner3.jpg') }}" alt="">
            </a>
        </div>
    </div>
@endsection

@section('menu-respon')
    @parent
@endsection
