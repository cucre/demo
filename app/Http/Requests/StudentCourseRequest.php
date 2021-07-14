<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentCourseRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'student_id' => [
                'required',
                Rule::unique('student_courses')->where(function ($query) {
                    return $query->where('student_id', $this->student_id)
                        ->where('course_id', $this->course_id);
                })
            ],
        ];
    }

    public function messages() {
        return [
            'required'      => 'El campo :attribute es obligatorio.',
            'unique'        => 'El campo :attribute ya existe.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'student_id'    => 'CUIP/Nombre del estudiante',
        ];
    }
}