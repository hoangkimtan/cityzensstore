@extends('layouts.home')

@section('content')
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ Route('post.list') }}" title="">Tin tức</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content" class="main-content fl-right">
        <div class="section" id="list-news-wp">
            @if ($list_post->count() > 0)
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($list_post as $item)
                            <li class="clearfix">
                                <a href="{{ Route('post.detail', [$item->slug, $item->id]) }}" title=""
                                    class="thumb fl-left">
                                    <img src="{{ asset($item->post_thumb) }}" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a
                                        href="{{ Route('post.list', $item->post_cat_id) }}">{{ $item->post_cat->post_cat_title }}</a>
                                    <a href="{{ Route('post.detail', [$item->slug, $item->id]) }}" title=""
                                        class="title">{{ $item->post_title }}</a>
                                    <span class="create-date">{{ $item->created_at }}</span>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <div class="section" id="pagination-wp">
                    <div class="pagination">

                    </div>
                </div>
            @else
                <div class="section-detail" id="list-product">
                    <div class='notification'>
                        <span class='d-block'>
                            <img class='img-fluid d-inline-block' src='{{ asset('images/noti-search.png') }}'>
                        </span>
                        <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn Vui lòng thử lại .</p>
                    </div>
                </div>
            @endif

        </div>
        <nav aria-label="Page navigation example">
            {{ $list_post->links() }}
        </nav>
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
                                <a href="" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
