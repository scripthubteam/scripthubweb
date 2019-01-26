<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScriptHubUsersRequest extends FormRequest
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
            'username' => 'bail|required|max:50',
            'email' => 'email|required|max:100',
            'password' => 'max:255',
            'repeat_password' => 'same:password|max:255',
            'avatar' => 'image',
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
