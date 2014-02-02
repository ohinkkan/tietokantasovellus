<?php

session_start();

function displayView($sivu, $data = array()) {
    $data = (object) $data;
    require 'views/pohja.php';
    exit();
}

function isLoggedIn() {
    if (isset($_SESSION['kirjautunut'])) {
       return TRUE;
    } else {
        displayView('kirjaudu.php');
    }
}

function logOut() {
    unset($_SESSION["kirjautunut"]);
}
