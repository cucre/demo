<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InstructorCourseRequest extends FormRequest {
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
            'instructor_id' => [
                'required',
                Rule::unique('instructor_courses')->where(function ($query) {
                   return $query->where('instructor_id', $this->instructor_id)
                      ->where('course_id', $this->course_id)
                      ->where('subject_id', $this->subject_id);
                })
            ],
            'subject_id'    => 'required'
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
            'instructor_id'    => 'CUIP/Nombre del instructor',
            'subject_id'       => 'Materia',
        ];
    }
}