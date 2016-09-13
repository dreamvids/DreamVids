<?php

if (\Model\Token::tokenExists(Request::get()->getArg(1))) {
    $redirect_url = \Model\Token::getRedirectUrl(Request::get()->getArg(1));
    
    if ($redirect_url !== false) {
        if (POST) {
            if ($_POST['username'] != '' && $_POST['password'] != '') {
                if (!\Model\Session::tryToConnect($_POST['username'], $_POST['password'])) {
                    Data::get()->add('error', Lang::get()->errors->credentials);
                }
            } else {
                Data::get()->add('error', Lang::get()->errors->empty);
            }
        }

        Data::get()->add('redirect', $redirect_url);
    }
    else {
        Data::get()->add('bad_token', true);
    }
}
else {
    Data::get()->add('bad_token', true);
}

Controller::renderView('auth/form', false);
