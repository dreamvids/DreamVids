<?php

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