<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->id;
        $task = $this->task;
        $condAvatar = '';
        $condUserName = '';
        $condEmail = '';
        $condPass = '';
        $condLevel = '';
        $condStatus = '';
        $condFullName = '';
        switch($task){
            case 'add':
                $condUserName = "bail|required|between:5,100|unique:$this->table,username";
                $condEmail = "bail|required|email|unique:$this->table,email";
                $condAvatar = 'bail|required|image|max:500';
                $condPass = 'bail|required|between:5,12|confirmed';
                $condStatus = 'bail|in:active,inactive';
                $condLevel = 'bail|in:admin,member';
                $condFullName = 'bail|required|min:5';
                break;
            case 'edit-info':
                $condUserName = "bail|required|between:5,100|unique:$this->table,username,$id";
                $condEmail = "bail|required|email|unique:$this->table,email,$id";
                $condAvatar = 'bail|image|max:500';
                $condStatus = 'bail|in:active,inactive';
                $condFullName = 'bail|required|min:5';
                break;
            case 'change-password':
                $condPass = 'bail|required|between:5,100|confirmed';
                break;
            case 'change-level':  
                $condLevel = 'bail|in:admin,member';
                break;
            default:
                break;
        }
        return [
            'username' => $condUserName,
            'email' => $condEmail,
            'fullname' => $condFullName,
            'status' => $condStatus,
            'level' => $condLevel,
            'password' => $condPass,
            'avatar' => $condAvatar
        ];
    }
    public function messages()
    {
        return [
            'username.required' => 'UserName không được rỗng!',
            'username.between' => 'UserName :input chiều dài phải có ít nhất :min kí tự và nhiều nhất :max kí tự!',
            'username.unique' => 'UserName :input đã tồn tại!',
            'fullname.required'  => 'Fullname không được rỗng!',
            'fullname.min' => 'Fullname :input chiều dài phải có ít nhất :min kí tự',
            'status.in' => 'Chọn status!',
            'level.in' => 'Chọn level!',
            'avatar.image' => 'Phải là ảnh!',
            'avatar.required' => 'Mời chọn ảnh!',
            'avatar.max' => 'Kích thước hình ảnh vượt quá :max kilobytes',
            'password.required' => "Nhập password!",
            'password.between' => "Password chiều dài từ :min đến :max kí tự!",
            'password.confirmed' => "Password không trùng khớp!",
            'email.required' => 'Email không được rỗng!',
            'email.email' => 'Email :input không đúng định dạng!',
            'email.unique' => 'Email :input đã tồn tại!',
        ];
    }
}
