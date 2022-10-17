@extends('layouts.home')
@section('content')
<div class="secion" id="breadcrumb-wp">
    <div class="secion-detail">
        <ul class="list-item clearfix">
            <li>
                <a href="{{ url('/') }}" title="">Trang chủ</a>
            </li>
            @if (session('action') == 'listProduct')
            @if ($list_breadcrumbs)
            @foreach ($list_breadcrumbs as $item)
            <li>
                <a class="{{ $cat->id == $item->id ? 'cat-name' : '' }}" href="{{ Route('product.list', [$item->slug, $item->id]) }}" title="">{{ $item->product_cat_title
                    }}</a>
            </li>
            @endforeach
            @endif
            @else
            <li>
                <a href="" title="">Tìm kiếm</a>
            </li>
            @endif
        </ul>
    </div>
</div>
<div class="main-content fl-right">
    <div class="section" id="list-product-wp">
        <div class="section-head clearfix" style="margin-bottom: 20px">
            @if (session('action') == 'listProduct')
            <h3 class="section-title fl-left" id="sort-cat-id" data-id="{{ $cat->id }}">
                <span class="cat-name">{{ $cat->product_cat_title }}</span>
            </h3>
            @else
            <h3 class="section-title fl-left" id="sort-cat-id" style="margin:0px">Tìm thấy
                {{ $list_product->count() }} sản phẩm
            </h3>
            @endif
            @if (session('action') == 'listProduct')
            <div class="filter-wp fl-right">
                <p class="count-product" style="margin-bottom:2px">Hiển thị {{ $list_product->count() }} sản
                    phẩm</p>
                <div class="form-filter">
                    <form method="POST" action="">
                        <select name="select" class="sort" data-url="{{ Route('product.sort') }}">
                            <option value="0">Sắp xếp</option>
                            <option value="1">Giá cao xuống thấp</option>
                            <option value="2">Giá thấp lên cao</option>
                        </select>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @if ($list_product->count() > 0)
        <div class="section-detail" id="list-product">
            <ul class="list-item clearfix">
                @foreach ($list_product as $item)
                <li>
                    <div class="img">
                        <a href="{{ Route('product.detail', [$item->slug, $item->id]) }}" title="" class="thumb">
                            <img src="{{ asset($item->product_thumb) }}" class="img-fluid">
                        </a>
                    </div>
                    <a href="{{ Route('product.detail', [$item->slug, $item->id]) }}" title="" class="product-name">{{
                        $item->product_title }}</a>
                    <div class="price">
                        <span class="new">{{ currency_format($item->price, '.đ') }}</span>
                    </div>
                    @if ($item->tracking=='out-of-stock')
                        <div class="sold-out">
                             <img src="{{asset('images/hethang.png')}}" alt="">
                         </div>
                    @endif
                    <div class="action clearfix">
                        @if ($item->tracking!='out-of-stock')
                        <a href="{{ Route('cart.get.add', $item->id) }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                        <a href="{{ Route('cart.buynow', $item->id) }}" title="Mua ngay" class="buy-now fl-right">Mua
                            ngay</a>
                            @else
                            <a href="{{ Route('cart.get.add', $item->id) }}" style="pointer-events: none;cursor:not-allowed" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                            <a href="{{ Route('cart.buynow', $item->id) }}" style="pointer-events: none;cursor:not-allowed" title="Mua ngay" class="buy-now fl-right">Mua
                                ngay</a>
                            @endif
                    </div>
                </li>
                @endforeach
            </ul>
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
    <div class="section" id="paging-wp">
        <div class="section-detail">
            {{ $list_product->links() }}
        </div>
    </div>
</div>
@endsection

{{-- sidebar --}}

@section('section-sidebar')
<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title" style="margin-bottom:0px">Danh mục sản phẩm</h3>
    </div>
    <div class="secion-detail">
        {{ get_cat($list_cat) }}
    </div>
</div>
@if (session('action') == 'listProduct')
<div class="section" id="filter-product-wp">
    <div class="section-head">
        <h3 class="section-title">Bộ lọc</h3>
    </div>
    <div class="section-detail">
        <form method="POST" action="" id="filter">
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Giá</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="radio" class="" data-url="{{ Route('product.filter.price') }}" value="1" name="r-price" id="under-1tr"></td>
                        <td class="test"><label for="under-1tr" class="mb-0">Dưới 1.000.000đ</label></td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="" data-url="{{ Route('product.filter.price') }}" value="2" name="r-price" id="1tr-5tr"></td>
                        <td><label for="1tr-5tr" class="mb-0">1.000.000đ - 5.000.000đ</label> </td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="" data-url="{{ Route('product.filter.price') }}" value="3" name="r-price" id="5tr-10tr"></td>
                        <td><label for="5tr-10tr" class="mb-0">5.000.000đ - 10.000.000đ</label></td>
                    </tr>
                    <tr>
                        <td><input type="radio" class="" data-url="{{ Route('product.filter.price') }}" value="4" name="r-price" id="over-10tr"></td>
                        <td><label for="over-10tr" class="mb-0">Trên 10.000.000đ</label></td>
                    </tr>
                </tbody>
            </table>
            @if ($list_trademark)
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Hãng</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_trademark as $item)
                    <tr>
                        <td><input type="radio" class="" data-url="{{ Route('product.filter.brand') }}" value="{{ $item->id }}" name="r-brand" id="{{$item->id}}"></td>
                        <td><label for="{{$item->id}}" class="mb-0">{{ $item->product_cat_title }}</label></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </form>
    </div>
</div>
@endif
@endsection