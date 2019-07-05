<?php
namespace App\Extensions;
use App\Models\CBSUser;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;

class CBSUserProvider implements UserProvider
{

    public function __construct () {

    }
    public function retrieveById ($identifier) {
        return CBSUser::find($identifier);
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
        $user = new CBSUser();
        foreach ($credentials as $credentialKey => $credentialValue) {
            if (!Str::contains($credentialKey, 'password')) {
                $user = $user->where($credentialKey, $credentialValue);
            }
        }
        return $user->first();
    }
    public function validateCredentials (Authenticatable $user, array $credentials) {
        $plain = $credentials['password'];
        $pw_hash = md5(md5($plain).$user->salt);
        return $pw_hash == $user->password;
    }
}