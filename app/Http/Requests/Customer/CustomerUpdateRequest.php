<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
        $table = \App\Customer::class;
        return [
            'fullname' => 'required',
            'email' => 'nullable|email',
            'address' => 'required',
            'phone' => ['required', 'regex:/(09|03|07|08|05)+([0-9]{8})/','unique:' . $table . ',phone,' . $this->id],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không để trống',
            'unique' => ':attribute đã tồn tại trong hệ thống',
            'min' => ':attribute nhỏ nhất là 6 kí tự',
            'regex' => ':attribute không đúng định dạng',
            'email' => ':attribute không đúng định dạng'
        ];
    }

    public function attributes()
    {
        return [
            'fullname' => 'Họ và tên',
            'address' => 'Địa chỉ chi tiết',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
        ];
    }
}
