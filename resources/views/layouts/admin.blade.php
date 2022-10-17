<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" href="{{ asset('admin/css/adminstyle.css') }}">
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script> --}}
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />


    <script src="https://cdn.tiny.cloud/1/s74er1dp3n2vqtl39an123a03d4jms2uiqlpg592i9m3x4kz/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        var editor_config = {
            path_absolute: "http://localhost/ban_hang_laravel7/",
            selector: 'textarea.editor',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document
                    .getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };
        tinymce.init(editor_config);
    </script>
    <title>Admintrator</title>
</head>

<body>
    <style>
        .top-right {
            bottom: 70px;
            right: 0;
        }

        .toast-container {
            position: fixed;
            z-index: 1055;
            margin: 5px;
        }
    </style>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow-lg navbar-light bg-dark d-flex">
            <div class="navbar-brand"><a href="{{ url('admin') }}" class="text-white">CITYZENS ADMIN</a></div>
            <div class="nav-right ">
                <div class="btn-group  ml-auto">
                    <button type="button" class="btn dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.user.edit', Auth::id()) }}" >Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        @php
            $module_active = session('module_active');
        @endphp
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-dark">
                <ul id="sidebar-menu" class="text-white">
                    <li class="nav-link {{ $module_active == 'dasboard' ? 'active' : '' }}">
                        <a href="{{ url('admin') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                        <a href="{{ Route('admin.page.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-file"></i>
                            </div>
                            Trang
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ Route('admin.page.create') }}">Thêm mới</a></li>
                            <li><a href="{{ Route('admin.page.index') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                        <a href="{{ Route('admin.post.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-book"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ Route('admin.post.create') }}">Thêm mới</a></li>
                            <li><a href="{{ Route('admin.post.index') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'post_cat' ? 'active' : '' }}">
                        <a href="{{ Route('admin.post_cat.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-store"></i>
                            </div>
                            Danh mục bài viết
                        </a>
                    </li>
                    <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }} ">
                        <a href="{{ Route('admin.product.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fab fa-product-hunt"></i>
                            </div>
                            Sản phẩm
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ Route('admin.product.create') }}">Thêm mới</a></li>
                            <li><a href="{{ Route('admin.product.index') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'product_cat' ? 'active' : '' }}">
                        <a href="{{ Route('admin.product_cat.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-store"></i>
                            </div>
                            Danh mục sản phẩm
                        </a>
                    </li>
                    <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                        <a href="{{ Route('admin.order.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-cart-arrow-down"></i>
                            </div>
                            Đơn hàng
                        </a>
                    </li>
                    <li class="nav-link {{ $module_active == 'customer' ? 'active' : '' }}">
                        <a href="{{ Route('admin.customer.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-people-carry"></i>
                            </div>
                            Khách hàng
                        </a>
                    </li>
                    <li class="nav-link {{ $module_active == 'slider' ? 'active' : '' }}">
                        <a href="{{ Route('admin.slider.index') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                            Slider
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ Route('admin.slider.create') }}">Thêm mới</a></li>
                            <li><a href="{{ Route('admin.slider.index') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                        <a href="{{ url('admin/user/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="fas fa-user"></i>
                            </div>
                            Users
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/user/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/user/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="wp-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="{{ asset('admin/js/app.js') }}"></script>
    <script src="{{ asset('dist/toast.min.js') }}"></script>
    {{-- <script type="text/javascript">
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            encrypted: true,
            cluster: "ap1"
        });
        var channel = pusher.subscribe('OrderNotificationEvent');
        channel.bind('order-notification', function(data) {
            $.ajax({
                url: "{{ route('admin.notification.get_id') }}",
                method: "GET",
                data: {},
                success: function(dataAjax) {
                    var url = `{{ url('admin/notification/mark-as-read/idOrder/idNotifi') }}`;
                    url = url.replace('idOrder/idNotifi', data.id_order + '/' + dataAjax);
                    var newNotificationHtml = `
                    <a class="dropdown-item" href="${url}">
                        <span>Bạn có đơn hàng mới từ ${data.fullname}</span><br>
                    </a>
                    `;
                    $('.menu-notification').prepend(newNotificationHtml);
                }
            });
            var count = $('.count-notification').text()
            count++
            $('.count-notification').text(count);
            if (count > 0) {
                $('.dropdown-item.empty').remove();
            }
            $.toast({
                type: "success",
                title: "Thông báo",
                subtitle: 'Bây giờ',
                content: "Bạn có đơn hàng mới từ " + data.fullname,
                delay: 20000,
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $("#selectall").change(function() {
                $(".select").prop('checked', $(this).prop("checked"));
            });

            $('.wp_checkbox').click(function() {
                $(this).parents('.card').find('.child_checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('.role-user').select2();
        });
    </script> --}}
</body>

</html>
