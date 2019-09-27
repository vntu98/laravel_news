<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $table = 'category';
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
        $condName = "required|between:5,100|unique:$this->table,name";
        if(!empty($id)){ // edit
            $condName .= ",$id";
        }
        return [
            'name' => $condName,
            'status' => 'bail|in:active,inactive',
            'is_home' => 'bail|in:1,0',
            'display' => 'bail|in:list,grid',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name không được rỗng!',
            'name.between' => 'Name :input chiều dài phải có ít nhất :min kí tự và nhiều nhất 100 kí tự!',
            'name.unique' => 'Name :input đã tồn tại!',
            'status.in' => 'Chọn status!',
            'is_home.in' => 'Chọn hiển thị!',
            'display.in' => 'Chọn kiểu hiện thị!',
        ];
    }
}
