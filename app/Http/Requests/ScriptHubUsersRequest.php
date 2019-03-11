<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Route;

use \App\ScriptHubUsers;

class ScriptHubUsersRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Getting ID based on route
        $user = Route::current()->user;
        // Creating user based on that ID
        $scriptHubUser = ScriptHubUsers::findOrFail($user);

        // Checking if username wasn't changed
        if ($this->has('username') && $this->input('username') == $scriptHubUser->username) {
            $this->request->remove('username');
        }

        // Checking if email wasn't changed
        if ($this->has('email') && $this->input('email') == $scriptHubUser->email) {
            $this->request->remove('email');
        }

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
            'username' => 'unique:scripthub_users,username|max:45',
            'email' => 'email|unique:scripthub_users,email|max:100',
            'password' => 'max:255',
            'repeat_password' => 'required_with:password|same:password|max:255',
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
