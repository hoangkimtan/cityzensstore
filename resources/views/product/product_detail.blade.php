@extends('layouts.home')
@if ($product)
    @section('content')
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    @foreach ($list_breadcrumbs as $item)
                        <li>
                            <a href="{{ Route('product.list', [$item->slug, $item->id]) }}"
                                title="">{{ $item->product_cat_title }}</a>
                        </li>
                    @endforeach
                    <li>
                        <a href="" title=""><?php echo create_slug($product->product_title); ?></a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <a href="" title="" id="main-thumb" style="">
                            <div style="position:relative;width:350px">
                                <img id="zoom" class="zoom" src="{{ asset($product->product_thumb) }}"
                                    data-zoom-image="{{ asset($product->product_thumb) }}" />
                            </div>
                        </a>
                        @if ($list_img)
                            <div id="list-thumb">
                                <a href="" data-image="{{ asset($product->product_thumb) }}"
                                    data-zoom-image="{{ asset($product->product_thumb) }}">
                                    <img id="zoom" src="{{ asset($product->product_thumb) }}" />
                                </a>
                                @foreach ($list_img as $item)
                                    <a href="" data-image="{{ asset($item->img_relative_thumb) }}"
                                        data-zoom-image="{{ asset($item->img_relative_thumb) }}">
                                        <img id="zoom" src="{{ asset($item->img_relative_thumb) }}" />
                                    </a>
                                @endforeach

                            </div>
                        @endif
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="{{asset($product->product_thumb)}}" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name">{{ $product->product_title }}</h3>
                        <div class="desc">
                            {!! $product->product_desc !!}
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status">{{ get_tracking($product->tracking) }}</span>
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <p class="price">{{ currency_format($product->price, '.đ') }}</p>
                            @if ($product->tracking == 'stocking')
                                <div id="num-order-wp" style="display:flex;width: 100px;justify-content: space-between;">
                                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                    <input type="text" name="num_order" value="1" readonly min="1" max="4"
                                        class="num-order" id="num-order">
                                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                </div>
                                <button class="add-cart">Thêm
                                    giỏ hàng</button>
                            @else
                                <div class="out-of-stock">Hết hàng</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    {!! $product->product_detail !!}
                </div>
                <p class="moredetail">
                    <span class="moredetail-item">Đọc thêm</span>
                </p>
            </div>
            <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5" data-width="100%">
            </div>
            @if ($list_product_same->count() > 0)
                <div class="section" id="same-category-wp">
                    <div class="section-head">
                        <h3 class="section-title">Cùng danh mục</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($list_product_same as $item)
                                <li>
                                    <div class="img">
                                        <a href="{{ Route('product.detail', [$item->slug, $item->id]) }}" title=""
                                            class="thumb">
                                            <img src="{{ asset($item->product_thumb) }}">
                                        </a>
                                    </div>
                                    <a href="{{ Route('product.detail', [$item->slug, $item->id]) }}" title=""
                                        class="product-name">{{ $item->product_title }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($item->price) }}.đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ Route('cart.get.add', $item->id) }}" title=""
                                            class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ Route('cart.buynow', $item->id) }}" title=""
                                            class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
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
        <div class="section" id="selling-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm bán chạy</h3>
            </div>
            @if ($list_best_sell->count() > 0)
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($list_best_sell as $item)
                            @php
                                $slug = create_slug($item->product_title);
                            @endphp
                            <li class="clearfix">
                                <a href="{{ Route('product.detail', [$slug, $item->id]) }}" title=""
                                    class="thumb fl-left">
                                    <img src="{{ asset($item->product_thumb) }}" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a href="{{ Route('product.detail', [$slug, $item->id]) }}" title=""
                                        class="product-name">{{ $item->product_title }}</a>
                                    <div class="price">
                                        <span class="new">{{ currency_format($item->price, '.đ') }}</span>
                                    </div>
                                    <a href="{{ Route('product.detail', [$slug, $item->id]) }}" title=""
                                        class="buy-now">Xem chi tiết</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endsection
@else
    @section('wp-content')
        @include('layouts.404')
    @endsection
@endif
