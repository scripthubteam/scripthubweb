<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BotsRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'prefix' => 'required|string|max:10|unique:bots,prefix',
            'info' => 'string',
            'fk_discord_users' => 'required|exists:discord_users,id|max:50',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'prefix.unique' => 'Este prefijo ya está en uso.',
            'fk_discord_users.exists' => 'Este usuario de Discord no existe.',
        ];
    }
}
