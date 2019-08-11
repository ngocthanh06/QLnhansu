<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            //
            'username' =>'unique:account,username,'.$this->segment(3).',id',
            'name' => 'min:3'    
        ];
    }
    public function messages(){
        return [
            'username.unique' =>'Username đã tồn tại',
            'name.min' => 'Họ tên không được bé hơn 3 ký tự'
        ];
    }
}
