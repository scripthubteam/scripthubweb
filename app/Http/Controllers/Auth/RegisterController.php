<?php

namespace App\Http\Controllers\Auth;

// use App\User;
use App\ScriptHubUsers;
use App\TempRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\CreateScripthubUserRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('users.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'username' => 'bail|required|unique:scripthub_users,username',
            'email' => 'required|email|unique:scripthub_users,email',
            'password' => 'required',
            'repeat_password' => 'required|same:password',
            'fk_discord_users' => 'required|exists:tmp_registration,discord_users_id',
            'hash_code' => 'required|exists:tmp_registration,hash_code',
        ];
        $messages = [
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'email.unique' => 'Este email ya está en uso.',
            'repeat_password.same' => 'Las contraseñas deben ser iguales.',
            'discord_users_id.exists' => 'El ID de Discord indicado no está registrado (¿Hiciste petición de registro con Script Hub Bot?).',
            'hash_code.exists' => 'El Token indicado no es correcto (¿Usaste el token dado por Script Hub Bot?).',
        ];
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\ScriptHubUsers
     */
    protected function create(array $data)
    {
        TempRegistration::deleteById($data['fk_discord_users']);
        return ScriptHubUsers::create($data);
    }
}
