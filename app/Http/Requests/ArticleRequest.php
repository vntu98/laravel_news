<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $table = 'article';
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
        $conditionThumb = 'bail|required|image|max:500';
        $condName = "required|between:5,100|unique:$this->table,name";
        if(!empty($id)){ // edit
            $conditionThumb = 'bail|image|max:500';
            $condName .= ",$id";
        }
        return [
            'name' => $condName,
            'content' => 'required',
            'status' => 'bail|in:active,inactive',
            'thumb' => $conditionThumb
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name không được rỗng!',
            'name.between' => 'Name :input chiều dài phải có ít nhất :min kí tự và nhiều nhất :max kí tự!',
            'name.unique' => 'Name :input đã tồn tại!',
            'content.required'  => 'Content không được rỗng!',
            'status.in' => 'Chọn status!',
            'thumb.image' => 'Phải là ảnh!',
            'thumb.required' => 'Mời chọn ảnh!',
            'thumb.max' => 'Kích thước hình ảnh vượt quá :max kilobytes'
        ];
    }
}
