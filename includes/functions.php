<?php

function initDataBaseConfig($dbHost, $dbUsername, $dbPassword) {
    $GLOBALS['config'] = array(
        'mysql' => array(
            'host' => $dbHost,
            'username' => $dbUsername,
            'password' => $dbPassword,
        )
    );
}

?>