<?php

require_once 'libs/utilities.php';
isLoggedIn();

resetTaskEdit();

resetPriorityEdit();

session_start();
require_once 'libs/connection.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';

// session data information specific to this page:
// session array 'tasktypedata' includes data for currently active (new or modified) tasktype.

// 'modify' is true if we are modifying an old tasktype
// variable $id is the id of this tasktype


if ($_GET['typeid'] > 0) {
    $id = $_GET['typeid'];
    $_SESSION['modify'] = true;
} else {
    $id = 0;
    unset($_SESSION['modify']);
    unset($_SESSION['tasktypedata']);
}

if (empty($_SESSION['tasktypedata']) OR $_GET['new']) {
    unset($_SESSION['tasktypedata']);
    $_SESSION['tasktypedata'] = array(
        'name' => "",
        'upper' => 0,
        'active' => 0,
    );
}
if ($id > 0 and empty($_SESSION['tasktypedata']['failed'])) {
    $activetype = tasktype::getTasktype($id);
    $_SESSION['tasktypedata']['active'] = $id;
    $_SESSION['tasktypedata']['name'] = $activetype->getName();
    $_SESSION['tasktypedata']['upper'] = $activetype->getUpper_id();
    unset($_SESSION['tasktypedata']['failed']);
} else {
        $_SESSION['tasktypedata']['active'] = 0;
}

if (isset($_GET['remove'])) {
    tasktype::delete($_GET['remove']);
    $_SESSION['note'] = 'Luokka poistettu.';
}

$_SESSION['tasktypedata']['tasktypes'] = tasktype::getTasktypesSorted($_SESSION['userid']);

$_SESSION['tasktypedata']['filter'] = htmlspecialchars($_GET["filter"]);


require 'views/ylapalkki.php';
displayView('views/luokat.php');
