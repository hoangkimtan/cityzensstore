<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'post_title' => 'required',
            'content' => 'required',
            'post_cat_id' => 'required',
            'post_thumb' => 'required|image'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không để trống',
            'image' => ':attribute không đúng định dạng'
        ];
    }

    public function attributes()
    {
        return [
            'post_title' => 'Tiêu đề bài viết',
            'content' => 'Nội dung bài viết',
            'post_cat_id' => 'Danh mục',
            'post_thumb' => "Ảnh bài viết"
        ];
    }
}
