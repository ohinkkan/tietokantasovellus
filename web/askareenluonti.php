<?php

require_once 'libs/utilities.php';
isLoggedIn();

resetTasktypeEdit();
resetPriorityEdit();

session_start();
require_once 'libs/connection.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';

// this controller is a mess. Had to start with the trickiest page. Perhaps I shall refactor it, someday.
//
// session data information specific to this page:
// session array 'taskdata' includes data for currently active (new or modified) task.
//
// of particular note is the sub-array 'newtasktypes' which includes
// the tasktypes which the task will have if saved.
//
// 'modify' is true if we are modifying an old task
// variable $id is the id of this task

$id = $_GET['id'];
if ($id > 0 or $_SESSION['taskdata']['modifytask'] > 0 ) {
    $_SESSION['modify'] = TRUE;
}
if (empty($_SESSION['taskdata']) OR $_GET['new']) {
    if ($_GET['new']) {
        unset($_SESSION['taskdata']);
        unset($_SESSION['modify']);
    }
    $_SESSION['taskdata'] = array(
        'modifytask' => $id,
        'name' => task::getTask($id)->getName(),
        'priority' => task::getTask($id)->getPriority_id(),
        'descr' => task::getTask($id)->getDescr(),
    );
}

$_SESSION['taskdata']['priorities'] = priority::getPrioritiesSorted($_SESSION['userid']);
$_SESSION['taskdata']['tasktypes'] = tasktype::getTasktypesSorted($_SESSION['userid']);

if (empty($_SESSION['taskdata']['priorities'])) {
    $_SESSION['virhe'] = "Ei yhtään tärkeysluokkaa tehtynä.";
    header('Location: index.php');
    exit();
}

if (empty($_SESSION['taskdata']['newtasktypes'])) {
    $_SESSION['taskdata']['newtasktypes'] = array();
    if ($id > 0) {
        $types = tasktype::getTypesForTask($id);
        foreach ($types as $type) {
            $_SESSION['taskdata']['newtasktypes'][$type->getId()] = $type->getId();
        }
    }
}

if (isset($_GET['add'])) {
    $_SESSION['taskdata']['newtasktypes'][$_GET['add']] = $_GET['add'];
}
if (isset($_GET['remove'])) {
    unset($_SESSION['taskdata']['newtasktypes'][$_GET['remove']]);
}
?>

<?php
require 'views/ylapalkki.php';
displayView('views/luoaskare.php');
