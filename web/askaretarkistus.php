<?php

require_once 'libs/utilities.php';
require_once 'libs/models/user.php';
require_once 'libs/connection.php';
require_once 'libs/models/task.php';

$name = htmlspecialchars($_POST['name']);
$descr = htmlspecialchars($_POST['descr']);
$priority = htmlspecialchars($_POST['priority']);
$_SESSION['taskdata']['name'] = $name;
$_SESSION['taskdata']['descr'] = $descr;
$_SESSION['taskdata']['priority'] = $priority;

if (empty($_POST['name'])) {
    $_SESSION['virhe'] = "Et antanut nimeä askareelle.";
    header('Location: askareenluonti.php');
} elseif (strlen($name) > 30) {
    $_SESSION['virhe'] = "Liian pitkä nimi askareelle.";
    header('Location: askareenluonti.php');
} elseif (strlen($descr) > 255) {
    $_SESSION['virhe'] = "Liian pitkä kuvaus askareelle.";
    header('Location: askareenluonti.php');
} elseif ($_SESSION['modify']) {
    task::delete($_SESSION['taskdata']['modifytask']);
    task::addTask($name, $descr, $priority);
    $_SESSION['note'] = "Askaretta muokattu onnistuneesti.";
    header('Location: index.php');
} else {
    task::addTask($name, $descr, $priority);
    $_SESSION['note'] = "Askare lisätty onnistuneesti.";
    header('Location: index.php');
}
