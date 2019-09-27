<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $table = 'user';
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
        $userName = $this->username;
        $condPass = 'bail|required|between:5,100';
        $condEmail = "bail|required|email";
        $condFullName = '';
        $condUserName = "";
        $condLevel = '';
        if($userName){
            $condPass .= '|confirmed';
            $condEmail .= "|unique:$this->table,email";
            $condUserName .= "|unique:$this->table,username";
            $condFullName = 'bail|required|min:5';
            $condUserName = "bail|required|between:5,100";
            $condLevel = 'bail|in:admin,member';
        }
        return [
            'email' => $condEmail,
            'password' => $condPass,
            'fullname' => $condFullName,
            'username' => $condUserName,
            'level' => $condLevel
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email không được rỗng!',
            'email.email' => 'Email :input không đúng định dạng!',
            'email.unique' => 'Email :input đã tồn tại!',
            'password.required' => "Nhập password!",
            'password.between' => "Password chiều dài từ :min đến :max kí tự!",
            'password.confirmed' => "Password không trùng khớp!",
            'fullname.required'  => 'Fullname không được rỗng!',
            'fullname.min' => 'Fullname :input chiều dài phải có ít nhất :min kí tự',
            'username.required' => 'UserName không được rỗng!',
            'username.between' => 'UserName :input chiều dài phải có ít nhất :min kí tự và nhiều nhất :max kí tự!',
            'username.unique' => 'UserName :input đã tồn tại!',
            'level.in' => 'Chọn level!',
        ];
    }
}
