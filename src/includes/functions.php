<?php

$db = NULL;

function prepare($query) {
    if($GLOBALS['db'] === NULL) {
        $GLOBALS['db'] = @new MySQLi(
            MYSQL_HOST,
            MYSQL_USER,
            MYSQL_PASSWD,
            MYSQL_DB
        );
        if (mysqli_connect_errno()) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true);
            die('Konnte keine Verbindung zu Datenbank aufbauen, MySQL meldete: '.mysqli_connect_error());
        }
    }
    $stmt = $GLOBALS['db']->prepare($query);
    if(!$stmt) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true);
        die('Could not prepare SQL-Command: ' . $GLOBALS['db']->error);
    }
    return $stmt;
}

function execute($stmt) {
    if(!$stmt->execute()) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true);
        die('Could not execute SQL-Command: ' . $stmt->error);
    }
}
