<?php

namespace App\Services;

class Permission
{
  const TABLE_MODULE = [
    'product' => 'sản phẩm',
    'page' => 'trang',
    'product_cat' => 'danh mục sản phẩm',
    'post' => 'bài viết',
    'post_cat' => 'danh mục bài viết',
    'order' => 'đơn hàng',
    'slider' => 'slider',
    'customer' => 'khách hàng',
    'user' => 'quản trị viên',
    'permission' => 'quyền',
    'role' => 'vai trò',
  ];

  const TABLE_ACTION = [
    'create' => 'Thêm mới',
    'edit' => 'Xem chi tiết',
    'update' => 'Sửa',
    'action' => 'Thao tác',
    'destroy' => 'Xóa',
    'index' => 'Xem danh sách',
    // 'delete' => 'Xóa vĩnh viễn'
  ];

  public function convertPermissionName($string)
  {
    $display_name = '';
    foreach (self::TABLE_ACTION as $key => $item) {
      if (strpos($string[2], $key) !== false) {
        $display_name .= $item . ' ';
        foreach (self::TABLE_MODULE as $key => $item) {
          if ($string[1] === $key) {
            $display_name .= $item;
          }
        }
      }
    }

    return $display_name;
  }
}
