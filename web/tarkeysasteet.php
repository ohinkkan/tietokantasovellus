<?php

require_once 'libs/utilities.php';
isLoggedIn();

resetTaskEdit();
resetTasktypeEdit();


session_start();
require_once 'libs/connection.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';

// session data information specific to this page:
// session array 'prioritydata' includes data for currently active (new or modified) priority.

// 'modify' is true if we are modifying an old priority
// variable $id is the id of this priority


if (isset($_GET['typeid'])) {
    $id = $_GET['typeid'];
    $_SESSION['modify'] = true;
} else {
    $id = 0;
    unset($_SESSION['modify']);
    unset($_SESSION['prioritydata']);
}

if (empty($_SESSION['prioritydata']) OR $_GET['new']) {
    unset($_SESSION['prioritydata']);
    $_SESSION['prioritydata'] = array(
        'name' => "",
        'importance' => 0,
        'active' => 0,
    );
}
if ($id > 0 and empty($_SESSION['prioritydata']['failed'])) {
    $activetype = priority::getPriority($id, $_SESSION['userid']);
    $_SESSION['prioritydata']['active'] = $id;
    $_SESSION['prioritydata']['name'] = $activetype->getName();
    $_SESSION['prioritydata']['importance'] = $activetype->getImportance();
    unset($_SESSION['prioritydata']['failed']);
} else {
    $_SESSION['prioritydata']['active'] = 0;
}

if (isset($_GET['remove'])) {
    priority::delete($_GET['remove']);
    $_SESSION['note'] = 'Tärkeysaste poistettu.';
}

$_SESSION['prioritydata']['priorities'] = priority::getPrioritiesSorted($_SESSION['userid']);

$_SESSION['prioritydata']['filter'] = htmlspecialchars($_GET["filter"]);


require 'views/ylapalkki.php';
displayView('views/tarkeys.php');
