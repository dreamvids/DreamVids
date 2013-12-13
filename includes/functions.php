<?php

function initDataBaseConfig($dbHost, $dbUsername, $dbPassword, $dbName) {
    $GLOBALS['config'] = array(
        'mysql' => array(
            'host' => $dbHost,
            'username' => $dbUsername,
            'password' => $dbPassword,
            'database' => $dbName
        )
    );
}

?>