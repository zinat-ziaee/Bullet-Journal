<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGoalCategorizeRequest extends FormRequest
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
            'title' => 'required|max:255',
        ];
    }

    public function messages(){
        return [
            'title.required' => 'عنوان را درج کنید',
            'title.max' => 'حداکثر 255 کاراکتر برای فیلد عنوان '
        ];
    }
}
