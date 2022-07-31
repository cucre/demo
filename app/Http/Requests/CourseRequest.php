<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest {
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
        $this->name = mb_strtoupper($this->name, 'UTF-8');
        $ignore = '';

        if($this->isMethod('put')) {
            $ignore = ','. $this->route('curso')->name;
        }

        return [
            'name'                => 'required|max:255|unique_unsensitive:courses,name'. $ignore,
            'classification'      => 'required',
            'hours'               => 'required|integer',
            'start_date'          => 'required|after_or_equal:end_date',
            'end_date'            => 'required|before_or_equal:start_date',
            'subjects'            => 'required|not_in:0',
        ];
    }

    public function messages() {
        return [
            'required'             => 'El campo :attribute es obligatorio.',
            'max'                  => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'unique_unsensitive'   => 'El campo :attribute ya existe.',
            'integer'              => 'El campo :attribute debe ser numérico.',
            'not_in'               => 'El campo :attribute seleccionado es inválido.',
            'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
            'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'name'            => 'Nombre del Curso',
            'classification'  => 'Clasificación',
            'hours'           => 'Total de horas',
            'start_date'      => 'Fecha inicio',
            'end_date'        => 'Fecha fin',
            'subjects'        => 'Materias',
        ];
    }
}