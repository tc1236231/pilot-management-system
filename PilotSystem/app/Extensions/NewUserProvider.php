<?php
namespace App\Extensions;
use App\Models\NewUser;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;

class NewUserProvider implements UserProvider
{

    public function __construct () {

    }
    public function retrieveById ($identifier) {
        return NewUser::find($identifier);
    }
    public function retrieveByToken ($identifier, $token) {
        return null;
    }
    public function updateRememberToken (Authenticatable $user, $token) {
        // update via remember token not necessary
    }
    public function retrieveByCredentials (array $credentials) {
        // implementation upto user.
        // how he wants to implement -
        // let's try to assume that the credentials ['username', 'password'] given
        $user = new NewUser();
        foreach ($credentials as $credentialKey => $credentialValue) {
            if (!Str::contains($credentialKey, 'password')) {
                $user = $user->where($credentialKey, $credentialValue);
            }
        }
        return $user->first();
    }
    public function validateCredentials (Authenticatable $user, array $credentials) {
        $plain = $credentials['password'];
        return \Hash::check($plain, $user->getAuthPassword());
    }
}