<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateScripthubUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'bail|required|unique:scripthub_users,username',
            'email' => 'required|email|unique:scripthub_users,email',
            'password' => 'required',
            'repeat_password' => 'required|same:password',
            'discord_users_id' => 'required|exists:tmp_registration,discord_users_id',
            'hash_code' => 'required|exists:tmp_registration,hash_code',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'email.unique' => 'Este email ya está en uso.',
            'repeat_password.same' => 'Las contraseñas deben ser iguales.',
            'discord_users_id.exists' => 'El ID de Discord indicado no está registrado (¿Hiciste petición de registro con Script Hub Bot?).',
            'hash_code.exists' => 'El Token indicado no es correcto (¿Usaste el token dado por Script Hub Bot?).',
        ];
    }

}
