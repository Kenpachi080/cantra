<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class itemReviewRequest extends FormRequest
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
            'item_id' => 'required',
            'name' => 'required',
            'city' => 'required',
            'auto' => 'required',
            'color' => 'required',
            'message' => 'required',
            'images' => 'required'
        ];
    }
}