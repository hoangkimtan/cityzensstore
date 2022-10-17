<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class SubmitOrderRequest extends FormRequest
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
            'fullname' => 'required|min:6',
            'city' => 'required',
            'district' => 'required',
            'commune' => 'required',
            'address' => 'required',
            'phone' => ['required', 'regex:/(09|03|07|08|05)+([0-9]{8})/'],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không để trống',
            'min' => ':attribute nhỏ nhất là 6 kí tự',
            'regex' => ':attribute không đúng định dạng'
        ];
    }

    public function attributes()
    {
        return [
            'fullname' => 'Họ và tên',
            'city' => 'Thành phố',
            'district' => 'Quận Huyện',
            'commune' => 'Phường Xã',
            'address' => 'Địa chỉ chi tiết',
            'phone' => 'Số điện thoại',
        ];
    }
}
