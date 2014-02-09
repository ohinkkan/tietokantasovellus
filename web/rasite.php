<?php

require_once 'libs/utilities.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/connection.php';

if ($_GET['donetoggle'] > 0) {
    task::getTask($_GET['donetoggle'])->toggleDone();
    header('Location: index.php');
}

if ($_GET['alldone'] > 0) {
    task::allDone();
    header('Location: index.php');
}

if ($_GET['work'] > 0) {
    task::workWork();
    header('Location: index.php');
}

if ($_GET['delete'] > 0) {
    task::delete($_GET['delete']);
    header('Location: index.php');
}

if ($_GET['logout'] > 0) {
    logout();
    header('Location: kirjautuminen.php');
}


