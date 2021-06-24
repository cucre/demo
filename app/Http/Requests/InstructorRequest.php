<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorRequest extends FormRequest {
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
        $this->email = mb_strtoupper($this->email);
        $ignore = '';

        if($this->isMethod('put')) {
            $ignore = ','. $this->route('instructore')->email;
        }

        return [
            'name'          => 'required|max:255',
            'paterno'       => 'required|max:255',
            'curp'          => array('required',
                                'min:18',
                                'max:18',
                                'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/'
                                ),
            'cuip'          => 'required|max:20',
            'birth_date'    => 'required',
            'email'         => 'required|email|unique_unsensitive:instructors,email'. $ignore,
            'telephone'     => 'required|integer',
            'medical_note'  => 'required',
        ];
    }

    public function messages() {
        return [
            'required'               => 'El campo :attribute es obligatorio.',
            'max'                    => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'email'                  => 'El campo :attribute debe ser una dirección de correo válida.',
            'min'                    => 'El campo :attribute debe de contener mínimo :min caracteres.',
            'unique_unsensitive'     => 'El campo :attribute ya existe.',
            'regex'                  => 'El formato de :attribute es inválido.',
            'integer'                => 'El campo :attribute debe ser numérico.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'name'             => 'Nombre',
            'paterno'          => 'Apellido Paterno',
            'curp'             => 'CURP',
            'cuip'             => 'CUIP',
            'birth_date'       => 'Fecha de nacimiento',
            'telephone'        => 'Teléfono/celular',
            'email'            => 'Correo electrónico',
            'medical_note'     => 'Nota médica',
        ];
    }
}