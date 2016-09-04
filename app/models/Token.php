<?php
/**
 * Created by PhpStorm.
 * User: peter_000
 * Date: 03/09/2016
 * Time: 14:48
 */

namespace Model;

class Token {
    public static function tokenExists(string $token): bool {
        $req = \Client::get()->prepare('GET', 'token/'.$token);
        $req->send();
        return ($req->getResponseCode() == 200);
    }

    public static function getRedirectUrl(string $token) {
        $req = \Client::get()->prepare('GET', 'token/'.$token);
        $req->send();
        if ($req->getResponseCode() == 200) {
            return $req->getResponseData()->token->redirect_url;
        }
        return false;
    }
}