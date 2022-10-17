<?php

namespace App\Http\Requests\ProductCat;

use Illuminate\Foundation\Http\FormRequest;

class ProductCatStoreRequest extends FormRequest
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
            'product_cat_title' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không để trống'
        ];
    }

    public function attributes()
    {
        return [
            'product_cat_title' => 'Tiêu đề danh mục'
        ];
    }
}
