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
    unset($_SESSION["id"]);
    session_unset();
}

function resetTaskEdit() {
    unset($_SESSION['taskdata']);
    unset($_SESSION['modify']);
}

function resetTasktypeEdit() {
    unset($_SESSION['tasktypedata']);
    unset($_SESSION['modify']);
}

function resetPriorityEdit() {
    unset($_SESSION['prioritydata']);
    unset($_SESSION['modify']);
}