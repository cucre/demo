<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest {
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
        $this->curp = mb_strtoupper($this->curp);
        $this->cuip = mb_strtoupper($this->cuip);
        $ignore = '';
        $ignore_curp = '';
        $ignore_cuip = '';
        $path_image = '';

        if($this->isMethod('put')) {
            $ignore = ','. $this->route('estudiante')->email;
            $ignore_curp = ','. $this->route('estudiante')->curp;
            $ignore_cuip = ','. $this->route('estudiante')->cuip;
        }

        return [
            'path_image'                   => $path_image .'file|mimes:jpeg,png,jpg|max:2048',
            'corporation_id'               => 'required',
            'type'                         => 'required',
            'name'                         => 'required|max:255',
            'paterno'                      => 'required|max:255',
            'curp'                         => array('required',
                                                'min:18',
                                                'max:18',
                                                'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/',
                                                'unique_unsensitive:students,curp'. $ignore_curp
                                            ),
            'cuip'                         => 'required|max:20|unique_unsensitive:students,cuip'. $ignore_cuip,
            'birth_date'                   => 'required',
            'email'                        => 'required|email|unique_unsensitive:students,email'. $ignore,
            'telephone'                    => 'required|integer',
            'emergency_contact'            => 'required|max:255',
            'telephone_emergency_contact'  => 'required|integer',
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
            'path_image'                   => 'Foto',
            'corporation_id'               => 'Corporación',
            'type'                         => 'Aspirante/Activo',
            'name'                         => 'Nombre',
            'paterno'                      => 'Apellido Paterno',
            'curp'                         => 'CURP',
            'cuip'                         => 'CUIP',
            'birth_date'                   => 'Fecha de nacimiento',
            'telephone'                    => 'Teléfono/celular',
            'email'                        => 'Correo electrónico',
            'emergency_contact'            => 'Contacto de emergencia',
            'telephone_emergency_contact'  => 'Teléfono/celular contacto',
        ];
    }
}