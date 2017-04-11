<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class loginRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {

        throw new ValidationException($validator);
        
    }
    protected function failedAuthorization()
    {
        abort(403, 'Autorization Failed');
    }
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
            'email'    => 'required|email',
            'password' => 'required'
        ];        
    }
}
