<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldStoreRequest extends FormRequest
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

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'error'=>$validator->errors()
        ], 401);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'location' => 'required',
            'image' => 'nullable',
            'description' => 'required',
            'rating' => 'required|integer',
            'begin_time' => 'required|date_format:H:i',
            'last_time' => 'required|date_format:H:i|after:last_time',
        ];
    }
}
