<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest {
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
        $this->subject = mb_strtoupper($this->subject);
        $ignore = '';

        if($this->isMethod('put')) {
            $ignore = ','. $this->route('materia')->subject;
        }

        return [
            'subject'       => 'required|max:255|unique_unsensitive:subjects,subject'. $ignore,
            'hours'         => 'required|integer',
        ];
    }

    public function messages() {
        return [
            'required'                  => 'El campo :attribute es obligatorio.',
            'max'                       => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'unique_unsensitive'        => 'El campo :attribute ya existe.',
            'integer'                   => 'El campo :attribute debe ser numérico.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'subject'  => 'Materia',
            'hours'    => 'Total de horas',
        ];
    }
}