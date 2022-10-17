<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderUpdateRequest extends FormRequest
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
            'slider_title' => 'required',
            'num_order' => 'required|integer',
            'slider_thumb' => 'image',
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
            'slider_title' => 'Tiêu đề slider',
            'num_order' => 'Thứ tự slider',
            'slider_thumb' => 'Ảnh slider',
        ];
    }
}
