<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
            'page_title' => 'required',
            'content' => 'required',
            'page_cat' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không để trống',
            'body.required' => 'A message is required',
        ];
    }

    public function attributes()
    {
        return [
            'page_title' => 'Tiêu đề',
            'content' => 'Nội dung không để trống',
            'page_cat' => 'Danh mục trang'
        ];
    }
}
