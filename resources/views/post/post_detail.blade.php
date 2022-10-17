@extends('layouts.home')
@if ($post)
@section('content')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="" title="">Blog</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-content fl-right">
        <div class="section" id="detail-blog-wp">
            <div class="section-head clearfix">
                <h3 class="section-title">{{ $post->post_title }}</h3>
            </div>
            <div class="section-detail">
                <span class="create-date">{{ $post->created_at }}</span>
                <div class="detail">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
        <div class="section" id="social-wp">
            <div class="section-detail">
                <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small"
                    data-show-faces="true" data-share="true"></div>
                <div class="g-plusone-wp">
                    <div class="g-plusone" data-size="medium"></div>
                </div>
                <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
            </div>
        </div>
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
                            <a href="{{ Route('product.detail', [$slug, $item->id]) }}" title="" class="thumb fl-left">
                                <img src="{{ asset($item->product_thumb) }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ Route('product.detail', [$slug, $item->id]) }}" title=""
                                    class="product-name">{{ $item->product_title }}</a>
                                <div class="price">
                                    <span class="new">{{ currency_format($item->price, '.đ') }}</span>
                                </div>
                                <a href="" title="" class="buy-now">Mua ngay</a>
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
