<?php

namespace App\Http\Controllers\Auth;

use App\Models\Pilot;
use App\Models\Platform;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'platforms' => Platform::where('shouquan','=',1)->get()
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'platform' => ['required',
                Rule::exists('platform','code')->where(function ($query) {
                    $query->where('shouquan', '=', 1);
                }),
                ],
            'callsign' => ['required', 'string', 'min:4', 'max:4', 'unique:pilots', 'unique:saved_huhao,huhao'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pilots', 'confirmed'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'icq' => ['required', 'string', 'max:20', 'unique:saved_icq,icq'],
            'toc_accepted' => ['required', 'accepted'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) : Pilot
    {
        return Pilot::create([
            'co' => $data['platform'],
            'callsign' => $data['callsign'],
            'email' => $data['email'],
            'level' => 0,
            'password' => Hash::make($data['password']),
            'icq' => 'QQ号' . ':' . $data['icq'],
        ]);
    }
}
