<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'name' => 'min:3',
            'username'=>'unique:account',

        ];
    }

    public function messages(){
        return [
            //
            'name.min'=>'Tên người dùng không được bé hơn 3 ký tự',
            'username.unique'=>'Username đã tồn tại'

        ];
    }
}
