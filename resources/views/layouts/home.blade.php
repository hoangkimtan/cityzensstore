<!DOCTYPE html>
<html>

<head>
    <title>CITYZENS STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('responsive.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <script src="{{ asset('js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    @toastr_css
</head>

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=1093184221176094&autoLogAppEvents=1"
        nonce="uVbuCAAI"></script>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <span id="payment-link" class="fl-left">Chào mừng đến với Cityzens</span>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="{{ url('/') }}" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ Route('post.list') }}" title="">Tin tức</a>
                                </li>
                                @if ($list_page_header)
                                    @foreach ($list_page_header as $item)
                                        <li>
                                            <a href="{{ Route('page.detail', [$item->slug, $item->id]) }}"
                                                title="">{{ $item->page_title }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{ url('/') }}" title="" id="logo" class="fl-left">CITYZENS</a>
                        <div id="search-wp" class="fl-left search-wp">
                            <form method="" action="{{ url('tim-kiem') }}">
                                <input type="text" name="key" id="s"
                                    placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button type="submit" value="Tìm kiếm" id="sm-s">Tìm kiếm</button>
                            </form>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0987654321</span>
                            </div>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="{{ url('gio-hang') }}" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">{{ Cart::count() }}</span>
                            </a>
                            <div id="cart-wp" class="fl-right">
                                <a href="{{ url('gio-hang') }}" id="btn-cart" style="color: #fff">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num" class="total-cart">{{ Cart::count() }}</span>
                                </a>
                                <div id="dropdown" style="min-height: 100px;">
                                    <p class="desc">Có <span class="total-cart"> {{ Cart::count() }} sản phẩm
                                        </span>trong giỏ hàng</p>
                                    <ul class="list-cart">
                                        @if (Cart::content())
                                            @foreach (Cart::content() as $item)
                                                <li class="clearfix">
                                                    <a href="" title="" class="thumb fl-left">
                                                        <img src="{{ Asset($item->options->product_thumb) }}"
                                                            alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="" title=""
                                                            class="product-name">{{ $item->product_title }}</a>
                                                        <p class="price product-{{ $item->rowId }}">
                                                            {{ currency_format($item->price, '.đ') }}</p>
                                                        <p class="qty ">Số lượng: <span
                                                                class="qty-{{ $item->rowId }}">{{ $item->qty }}</span>
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    @if (Cart::count() > 0)
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right total">
                                                {{ currency_format(Cart::total(), '.đ') }}
                                            </p>
                                        </div>
                                        <div class="action-cart clearfix">
                                            <a href="{{ url('gio-hang') }}" title="Giỏ hàng"
                                                class="view-cart fl-left">Giỏ
                                                hàng</a>
                                            <a href="{{ url('thanh-toan') }}" title="Thanh toán"
                                                class="checkout fl-right">Thanh
                                                toán</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content-wp" class="home-page clearfix">
                <div class="wp-inner">
                    @yield('wp-content')
                    @yield('content')
                    <div class="sidebar fl-left">
                        @yield('section-sidebar')
                    </div>
                </div>
            </div>
            <div id="footer-wp">
                <div id="foot-body">
                    <div class="wp-inner clearfix">
                        <div class="block" id="info-company">
                            <h3 class="title">CITYZENS</h3>
                            <p class="desc">CITYZENS luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ
                                ràng, chính
                                sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                        </div>
                        <div class="block menu-ft" id="info-shop">
                            <h3 class="title">Thông tin cửa hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <p>1999 - Đường Láng - Hà Nội</p>
                                </li>
                                <li>
                                    <p>0987654321</p>
                                </li>
                                <li>
                                    <p>thaihoang@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                        <div class="block menu-ft policy" id="info-shop">
                            <h3 class="title">Chính sách mua hàng</h3>
                            <ul class="list-item">
                                @if ($list_page_footer)
                                    @foreach ($list_page_footer as $item)
                                        <li>
                                            <a href="{{ Route('page.detail', [$item->slug, $item->id]) }}"
                                                title="">{{ $item->page_title }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="block" id="newfeed">
                            <h3 class="title">Bảng tin</h3>
                            <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                            <div id="form-reg">
                                <form method="" action="">
                                    @csrf
                                    <input type="email" name="email" id="email"
                                        placeholder="Nhập email tại đây">
                                    <button type="submit" id="sm-reg">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="foot-bot">
                    <div class="wp-inner">
                        <p id="copyright" style="margin-bottom:0px">© Bản quyền thuộc về Nguyễn Sỹ Thái Hoàng
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="menu-respon">
            <a href="{{ url('/') }}" title="" class="logo" style="background: #000; color:#fff; border-top:1px solid #999">CITYZENS</a>
            <div id="search-wp" class="">
                <form method="" action="{{ url('tim-kiem') }}">
                    <input type="text" name="key" id="s"
                        placeholder="Nhập từ khóa tìm kiếm tại đây!">
                    <button type="submit" value="Tìm kiếm" id="sm-s">Tìm kiếm</button>
                </form>
            </div>
            <div id="menu-respon-wp">
                {{ get_cat_respon($list_cats, $list_page_header) }}
            </div>
        </div>
        <div id="btn-top"><img src="{{ asset('images/icon-to-top.png') }}" alt="" /></div>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        @toastr_js
        @toastr_render
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script> --}}

</body>

</html>
