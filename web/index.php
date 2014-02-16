<?php

require_once 'libs/utilities.php';
isLoggedIn();

session_start();
resetTaskEdit();
resetTasktypeEdit();
resetPriorityEdit();
require_once 'libs/connection.php';
require_once 'libs/models/user.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';


$data = array(
    'tasklist' => task::getTasksSorted($_SESSION['userid']),
    'taskId' => (int) $_GET['taskId'],
    'active' => task::getTask($_GET['taskId']),
    'activetasktypes' => tasktype::getTasktypes(task::getTask($_GET['taskId'])->getId()),
    'filter' => htmlspecialchars($_GET["filter"]),
);

require 'views/ylapalkki.php';
displayView('views/etusivu.php', $data);
