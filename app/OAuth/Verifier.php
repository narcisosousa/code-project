<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 30/01/2017
 * Time: 17:21
 */

namespace CodeProject\OAuth;
Use Auth;

class Verifier
{

    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }

}