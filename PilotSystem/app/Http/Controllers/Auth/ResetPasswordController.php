<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pilot;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords {
        reset as parent_reset;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/password/reset';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'callsign' => 'required|string|min:4|max:4|exists:pilots',
            'password' => 'required|confirmed|min:8'
        ];
    }

    public function reset(Request $request)
    {
        $email = $request->get('email', '');
        $callsign = $request->get('callsign', '');

        $pilot = Pilot::where('callsign', '=', $callsign)->first();
        if($pilot)
        {
            if($email != $pilot->email)
                throw ValidationException::withMessages(['email' => '呼号邮箱不匹配']);
        }
        else
        {
            throw ValidationException::withMessages(['email' => '呼号不存在']);
        }

        return $this->parent_reset($request);
    }

    public function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
        $this->guard()->login($user);
    }
}
