<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
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
        $this->email = mb_strtoupper($this->email, 'UTF-8');
        $ignore = '';

        if($this->isMethod('put')) {
            $ignore = ','. $this->route('usuario')->email;
        }

        return [
            'name'    => 'required|max:255',
            'email'   => 'required|max:255|email|unique_unsensitive:users,email' . $ignore,
            'rol'     => 'required',
        ];
    }

    public function messages() {
        return [
            'required'           => 'El campo :attribute es obligatorio',
            'unique_unsensitive' => 'El :attribute ya existe',
            'min'                => 'Debe de contener mínimo :attribute caracteres',
        ];
    }

    public function attributes() {
        return [
            'name'                  => 'Nombre',
            'email'                 => 'Correo electrónico',
            'password'              => 'Contraseña',
            'password_confirmation' => 'Confirmación contraseña',
            'rol'                   => 'Rol',
        ];
    }
}
