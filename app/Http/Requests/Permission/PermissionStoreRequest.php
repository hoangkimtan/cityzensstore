<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required',
            'key_code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không để trống',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên quyền',
            'key_code' => 'Key code',
        ];
    }
}
