<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Bots;

class ModifyBotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Getting BotID
        $bot = Route::current()->bot_id;
        // Creating bot from current
        $bot = Bots::findOrFail($bot);

        // Checking if prefix wasn't changed
        if ($this->has('prefix') && $this->input('prefix') == $bot->prefix) {
            $this->request->remove('prefix');
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
            'name' => 'string|max:50|min:1',
            'prefix' => 'string|max:10|min:1|unique:bots,prefix',
            'info' => 'string',
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
            'prefix.unique' => 'Este prefijo ya está en uso.',
        ];
    }
}
