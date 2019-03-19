<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserinfoStoreRequest extends FormRequest
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
            'phone' => 'required|regex:/^1{1}[3-9]{1}[\d]{9}$/',
            'pwd' => 'required',
        ];
    }

    // 自定义错误信息
    public function messages()
    {
        return [
            'phone.required'=>'手机号不能为空',
            'phone.regex'=>'请输入正确的11位手机号',
            'pwd.required'=>'密码null',
            // 'pwd.confirmed'=>'密码不正确',
        ];
    }
}
