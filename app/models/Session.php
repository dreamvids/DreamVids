<?php

namespace Model;

class Session implements \Modelable {
    private static $session = null;

    public static function tryToConnect(string $username, string $password, $cookie = false): bool {
        $req = \Client::get()->prepare('POST', 'session', [
            'username' => $username,
            'password' => $password
        ]);
        $req->send();

        if ($req->getResponseCode() == 201) {
            self::$session = $req->getResponseData()->session->session_id;
            \Client::get()->setSessid(self::$session);
            
            if ($cookie) {
                setcookie(
                    'SESSID',
                    $req->getResponseData()->session->session_id,
                    $req->getResponseData()->session->expiration_timestamp,
                    WEBROOT
                );
            }
            return true;
        }

        return false;
    }

    public static function getSession() {
        return self::$session;
    }

    public static function isLogged(): bool {
        if (isset($_COOKIE['SESSID'])) {
            $req = \Client::get()->prepare('GET', 'session/'.$_COOKIE['SESSID']);
            $req->send();
            
            return ($req->getResponseCode() == 200);
        }
        return false;
    }
}