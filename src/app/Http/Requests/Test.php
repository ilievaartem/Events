<?php

namespace App\Http\Requests;

use App\Constants\Request\UserRequestConstants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class Test extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return true;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserRequestConstants::NAME => 'required|max:25',
            UserRequestConstants::EMAIL => 'required|unique:users|email:rfc|max:60',
            UserRequestConstants::ROLE => 'required|string|max:30',
            UserRequestConstants::TELEPHONE => 'required|string|min:7|max:30',
            UserRequestConstants::PASSWORD => 'required|min:3|max:30'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new \Exception(response()->json(['errors' => $validator->errors()], 422));
    }
}
