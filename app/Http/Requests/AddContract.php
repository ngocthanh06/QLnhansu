<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddContract extends FormRequest
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
            'num_max' => 'required',
            'coefficients' => 'required',
        ];
    }
    public function messages()
    {
        return [
            //
            'num_max.required' => 'Bạn phải chọn hình thức để setup ngày phép tối đa',
            'coefficients.required' => 'Bạn phải chọn loại hợp đồng để setup hệ số lương'
        ];
    }
}
