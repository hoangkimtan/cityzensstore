<?php
return [
    [
        'label' => 'Trang',
        'route' => 'admin.page.index',
        'icon' => 'far fa-file',
        'module_active' => 'page',
        'items' => [
            [
                'label' => 'Thêm mới',
                'route' => 'admin.page.create',
            ],
            [
                'label' => 'Danh sách',
                'route' => 'admin.page.index'
            ],
        ],
    ],
    [
        'label' => 'Danh mục bài viết',
        'route' => 'admin.post_cat.index',
        'icon' => 'fas fa-store',
        'module_active' => 'post_cat',
        'items' => [
            [
                'label' => 'Thêm mới',
                'route' => 'admin.post_cat.index',
            ],
            [
                'label' => 'Danh sách',
                'route' => 'admin.post_cat.index'
            ],
        ],
    ],
    [
        'label' => 'Bài viết',
        'route' => 'admin.post.index',
        'icon' => 'fas fa-book',
        'module_active' => 'post',
        'items' => [
            [
                'label' => 'Thêm mới',
                'route' => 'admin.post.create',
            ],
            [
                'label' => 'Danh sách',
                'route' => 'admin.post.index'
            ],
        ],
    ],
    [
        'label' => 'Danh mục sản phẩm',
        'route' => 'admin.product_cat.index',
        'icon' => 'fas fa-store',
        'module_active' => 'product_cat',
        'items' => [
            [
                'label' => 'Thêm mới',
                'route' => 'admin.product_cat.index',
            ],
            [
                'label' => 'Danh sách',
                'route' => 'admin.product_cat.index'
            ],
        ],
    ],
    [
        'label' => 'Sản phẩm',
        'route' => 'admin.product.index',
        'icon' => 'fab fa-product-hunt',
        'module_active' => 'product',
        'items' => [
            [
                'label' => 'Thêm mới',
                'route' => 'admin.product.create',
            ],
            [
                'label' => 'Danh sách',
                'route' => 'admin.product.index'
            ],
        ],
    ],
    [
        'label' => 'Đơn hàng',
        'route' => 'admin.order.index',
        'icon' => 'fas fa-cart-arrow-down',
        'module_active' => 'order',
        'items' => [
            [
                'label' => '',
                'route' => '',
            ],
            [
                'label' => '',
                'route' => '',
            ]
        ],
    ],
    [
        'label' => 'Khách hàng',
        'route' => 'admin.customer.index',
        'icon' => 'fas fa-people-carry',
        'module_active' => 'customer',
        'items' => [
            [
                'label' => '',
                'route' => '',
            ],
            [
                'label' => '',
                'route' => '',
            ]
        ],
    ],
    [
        'label' => 'Slider',
        'route' => 'admin.slider.index',
        'icon' => 'fas fa-sliders-h',
        'module_active' => 'slider',
        'items' => [
            [
                'label' => 'Thêm mới',
                'route' => 'admin.slider.create',
            ],
            [
                'label' => 'Danh sách',
                'route' => 'admin.slider.index'
            ],
        ],
    ],
    [
        'label' => 'User',
        'route' => 'admin.user.index',
        'icon' => 'fas fa-user',
        'module_active' => 'user',
        'items' => [
            [
                'label' => 'Thêm mới',
                'route' => 'admin.user.create',
            ],
            [
                'label' => 'Danh sách',
                'route' => 'admin.user.index'
            ],
        ],
    ]
];
