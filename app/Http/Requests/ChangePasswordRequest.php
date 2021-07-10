<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest {
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
            'current_password'      => 'required|max:255',
            'password'              => 'required|max:255|same:password_confirmation|min:6|different:current_password',
            'password_confirmation' => 'required',
        ];
    }

    public function messages() {
        return [
            'required'           => 'El campo :attribute es obligatorio',
            'min'                => 'Debe de contener mínimo :attribute caracteres',
            'same'               => 'Los campos :attribute y :other deben coincidir.',
            'different'          => 'Los campos :attribute y :other deben ser diferentes.',
        ];
    }

    public function attributes() {
        return [
            'current_password'      => 'Contraseña actual',
            'password'              => 'Nueva Contraseña',
            'password_confirmation' => 'Confirmación nueva contraseña',
        ];
    }
}
