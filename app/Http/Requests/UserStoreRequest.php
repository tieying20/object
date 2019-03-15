<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'u_name' => 'unique:user,u_name',
            'pwd' => 'required|regex:/^[\w]{6,}$/',
            'repass' => 'required|same:pwd',
            'phone' => 'required|unique:user,phone|regex:/^1{1}[3-9]{1}[\d]{9}$/',
        ];
    }

    // 自定义错误信息
    public function messages()
    {
        return [
            'u_name.unique'=>'此昵称已存在',
            'pwd.required'=>'密码不能为空',
            'pwd.regex'=>'密码不能少于6位',
            'repass.required'=>'确认密码不能为空',
            'repass.same'=>'俩次密码不一致',
            'phone.required'=>'手机号不能为空',
            'phone.regex'=>'手机号格式不正确',
            'phone.unique'=>'手机号已存在',
        ];
    }
}
