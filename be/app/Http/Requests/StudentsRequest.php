<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class StudentsRequest extends FormRequest
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
            'student_id' => 'bail|required|max:15|unique:users,student_id',
            'email' => 'unique:users,email',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
            'first_name' => 'required|bail|max:50',
            'middle_name' => 'required|bail|max:50',
            'last_name' => 'required|bail|max:50',
            'gender' => 'required|bail|max:15',
            'year_level' => 'required|bail|max:10',
            'type' => 'required|bail|max:15',
            'section_id' => 'required|bail|exists:sections,id',
            'organization_id' => 'required|bail|exists:organizations,id',
            'course_id' => 'required|bail|exists:courses,id',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
