<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalRequest extends FormRequest
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
      'goal_categorizes_id' => 'required|exists:goal_categorizes,id'
    ];
  }
  public function messages()
  {
    return [
      'goal_categorizes_id.required' => 'یک گروه را انتخاب نمایید',
      'goal_categorizes_id.exists' => 'گروه انتخابی معتبر نیست'
    ];
  }
}
