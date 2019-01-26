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
            'username' => 'bail|required|unique:scripthub_users,username|max:50',
            'email' => 'email|required|unique:scripthub_users,email|max:100',
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
            'avatar.image' => 'El avatar debe ser una imagen.',
        ];
    }
}
