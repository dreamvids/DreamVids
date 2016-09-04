<?php
/**
 * Created by PhpStorm.
 * User: peter_000
 * Date: 04/09/2016
 * Time: 17:35
 */

namespace Model;


class User {
    public static function tryRegister(string $username, string $email, string $password) {
        $req = \Client::get()->prepare('POST', 'user', [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
        $req->send();
        return ($req->getResponseCode() == 201);
    }
}