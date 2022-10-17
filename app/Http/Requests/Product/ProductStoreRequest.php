<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_title' => 'required',
            'price' => 'required|integer',
            'qty' => 'required|integer',
            'product_desc' => 'required',
            'product_detail' => 'required',
            'product_cat_id' => 'required',
            'product_thumb' => 'required|image',
            'product_thumb_relative[]' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'integer' => ':attribute phải là số nguyên',
            'image' => ':attribute phải dạng ảnh'
        ];
    }

    public function attributes()
    {
        return [
            'product_title' => 'Tên sản phẩm',
            'price' => 'Giá sản phẩm',
            'qty' => 'Số lượng sản phẩm',
            'product_desc' => 'Mô tả ngắn sản phẩm',
            'product_detail' => 'Chi tiết sản phẩm',
            'product_thumb' => 'Ảnh của sản phẩm',
            'product_thumb_relative' => 'Ảnh liên quan sản phẩm',
            'product_cat_id' => 'Danh mục sản phẩm'
        ];
    }
}
