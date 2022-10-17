<?php

if (!function_exists('create_slug')) {
    function create_slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
}

function data_tree($data, $parent_id = 0, $level = 0)
{
    $result = array();
    foreach ($data as $item) {
        if ($item['parent_id'] == $parent_id) {
            $item['level'] = $level;
            $result[] = $item;
            $child = data_tree($data, $item['id'], $level + 1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}

function currency_format($number, $suffix = 'đ')
{
    return number_format($number) . $suffix;
}

function get_tracking($tracking)
{
    if ($tracking == "stocking") {
        return "Còn hàng";
    } else {
        return "Hết hàng";
    }
}

function get_tracking_css($tracking)
{
    if ($tracking == "stocking") {
        return "success";
    } else {
        return "dark";
    }
}

//$id=$info_cat['parent_id'];
function get_breadcrumb($list_product_cat, $id)
{
    $result = array();
    foreach ($list_product_cat as $k => $item) {
        if ($item['id'] == $id) {
            $result[] = $item;
            $child = get_breadcrumb($list_product_cat, $item['parent_id']);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}

function get_cat($data, $parent_id = 0, $level = 0)
{
    $result = array();
    foreach ($data as $key => $item) {
        if ($item['parent_id'] == $parent_id) {
            $result[] = $item;
            unset($data[$key]);
        }
    }
    if ($result) {
        if ($level == 0) {
            $class = " class='list-item' ";
        } else {
            $class = " class='sub-menu'";
        }
        echo  "<ul" . $class . ">";
        foreach ($result as $key => $item) {
            $name = Route('product.list', ['slug' => $item['slug'], 'id' => $item['id']]);
            echo  "<li><a href='{$name}'>{$item['product_cat_title']}</a>";
            get_cat($data, $item['id'], $level + 1);
            echo "</li>";
        }
        echo "</ul>";
    }
}

function get_cat_respon($data, $list_page_header , $parent_id = 0, $level = 0)
{
    $result = array();
    foreach ($data as $key => $item) {
        if ($item['parent_id'] == $parent_id) {
            $result[] = $item;
            unset($data[$key]);
        }
    }
    if ($result) {
        if ($level == 0) {
            $class = " id='main-menu-respon'";
        } else {
            $class = " class='sub-menu' ";
        }
        echo  "<ul" . $class . ">";
        echo  "<li><a href='home'>Trang chủ</a>";
        foreach ($result as $key => $item) {
            $name = Route('product.list', ['slug' => $item['slug'], 'id' => $item['id']]);
            echo  "<li><a href='{$name}'>{$item['product_cat_title']}</a>";
            get_cat($data, $item['id'], $level + 1);
            echo "</li>";
        }
        $post_url = url('tin-tuc');
        echo "<li><a href='{$post_url}'>Bài viết</a>";
        foreach($list_page_header as $key =>$item){
            $name = Route('page.detail', ['slug' => $item['slug'], 'id' => $item['id']]);
            echo  "<li><a href='{$name}'>{$item['page_title']}</a>";
        }
        // echo  "<li><a href='lien-he'>Liên hệ</a>";
        // echo  "<li><a href='gioi-thieu'>Giới Thiệu</a>";
        echo "</ul>";
    }
}

function cat_filter($data, $parent_id)
{
    $result = array();
    foreach ($data as $item) {
        if ($item['parent_id'] == $parent_id) {
            $result[] = $item;
        }
    }
    return $result;
}

function get_status_order($status)
{
    if ($status == "pending") {
        return "Đang chờ duyệt";
    } elseif ($status == "completed") {
        return "Thành công";
    } elseif ($status == 'cancel') {
        return "Hủy";
    } elseif ($status == 'confirmed') {
        return "Đã xác nhận";
    } else {
        return "Đang vận chuyển";
    }
}

function get_status_order_css($status)
{
    if ($status == "pending") {
        return "warning";
    } elseif ($status == "completed") {
        return "success";
    } elseif ($status == "shipping") {
        return "primary";
    } elseif ($status == "confirmed") {
        return "info";
    } else {
        return "dark";
    }
}

function get_payment_method($payment_method)
{
    if ($payment_method == "at-home")
        return "Thanh toán khi nhận hàng";
    return "Thanh toán ngân hàng";
}

function get_subtotal($price, $qty)
{
    return $price * $qty;
}
