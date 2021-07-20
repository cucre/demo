<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStatusRequest extends FormRequest {
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
        $this->name = mb_strtoupper($this->name);
        $ignore = '';

        if($this->isMethod('put')) {
            $ignore = ','. $this->route('estatus')->name;
        }

        return [
            'name'        => 'required|max:255|unique_unsensitive:student_statuses,name'. $ignore,
            'description' => 'max:255',
        ];
    }

    public function messages() {
        return [
            'required'                  => 'El campo :attribute es obligatorio.',
            'max'                       => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'unique_unsensitive'        => 'El campo :attribute ya existe.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'name'           => 'Estatus',
            'description'    => 'Descripción',
        ];
    }
}