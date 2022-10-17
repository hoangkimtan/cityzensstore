<?php

namespace App\Http\Requests\PostCat;

use Illuminate\Foundation\Http\FormRequest;

class PostCatStoreRequest extends FormRequest
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
            'post_cat_title' => 'required'
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
            'post_cat_title' => 'Tiêu đề danh mục'
        ];
    }
}
