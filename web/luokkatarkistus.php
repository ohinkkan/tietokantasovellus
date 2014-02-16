<?php

require_once 'libs/utilities.php';
require_once 'libs/models/user.php';
require_once 'libs/connection.php';
require_once 'libs/models/task.php';
require_once 'libs/models/tasktype.php';

$name = htmlspecialchars($_POST['name']);
$upper = htmlspecialchars($_POST['upper']);
$active = htmlspecialchars($_SESSION['tasktypedata']['active']);
$_SESSION['tasktypedata']['name'] = $name;
$_SESSION['tasktypedata']['upper'] = $upper;


if (empty($_POST['name'])) {
    $_SESSION['tasktypedata']['failed'] = true;
    $_SESSION['virhe'] = "Et antanut nimeä askareluokalle.";
    header('Location: askareluokat.php');
} elseif (strlen($name) > 30) {
    $_SESSION['tasktypedata']['failed'] = true;
    $_SESSION['virhe'] = "Liian pitkä nimi askareluokalle.";
    header('Location: askareluokat.php');
} elseif ($_SESSION['modify']) {
    unset($_SESSION['modify']);
    tasktype::updateTasktype($name, $upper, $active);
    $_SESSION['note'] = "Askareluokkaa muokattu onnistuneesti.";
    unset($_SESSION['tasktypedata']);
    header('Location: askareluokat.php');
} else {
    tasktype::addTasktype($name, $upper);
    $_SESSION['note'] = "Askareluokka lisätty onnistuneesti.";
    unset($_SESSION['tasktypedata']);
    header('Location: askareluokat.php');
}
