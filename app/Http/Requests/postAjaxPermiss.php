<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class postAjaxPermiss extends FormRequest
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
            'content'=>'required',
            'date_end' =>'after_or_equal:date_start',
            

            
        ];
    }

    public function messages(){
        return [    
            'content.required' => 'Lí do đơn xin phép không được để trống',
            'date_end.after_or_equal' =>'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',
        ];
    }
}
