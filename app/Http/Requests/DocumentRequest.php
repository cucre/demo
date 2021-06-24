<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest {
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
        $path_image_required = 'required|';

        if($this->isMethod('put')) {
            $path_image_required = '';
        }

        return [
            'name' => 'required|max:255',
            'path' => $path_image_required .'file|mimes:pdf|max:5120',
        ];
    }

    public function messages() {
        return [
            'required'             => 'El campo :attribute es obligatorio.',
            'max'                  => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'file'                 => 'El campo :attribute debe ser un archivo.',
            'mimes'                => 'El campo :attribute debe ser un archivo con formato: :values.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'name'    => 'Nombre del documento',
            'path'    => 'Documento',
        ];
    }
}