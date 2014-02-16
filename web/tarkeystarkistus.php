<?php

require_once 'libs/utilities.php';
require_once 'libs/models/user.php';
require_once 'libs/connection.php';
require_once 'libs/models/task.php';
require_once 'libs/models/priority.php';

$name = htmlspecialchars($_POST['name']);
$importance = htmlspecialchars($_POST['importance']);
$active = htmlspecialchars($_SESSION['prioritydata']['active']);
$_SESSION['prioritydata']['name'] = $name;
$_SESSION['prioritydata']['importance'] = $importance;

if (empty($_POST['name'])) {
    $_SESSION['prioritydata']['failed'] = true;
    $_SESSION['virhe'] = "Et antanut nimeä tärkeysasteelle.";
    header('Location: tarkeysasteet.php');
} elseif (strlen($name) > 30) {
    $_SESSION['prioritydata']['failed'] = true;
    $_SESSION['virhe'] = "Liian pitkä nimi tärkeysasteelle.";
    header('Location: tarkeysasteet.php');
} elseif ($_SESSION['modify']) {
    unset($_SESSION['modify']);
    priority::updatePriority($name, $importance, $active);
    $_SESSION['note'] = "Tärkeysastetta muokattu onnistuneesti.";
    unset($_SESSION['prioritydata']);
    header('Location: tarkeysasteet.php');
} else {
    priority::addPriority($name, $importance);
    $_SESSION['note'] = "Tärkeysaste lisätty onnistuneesti.";
    unset($_SESSION['prioritydata']);
    header('Location: tarkeysasteet.php');
}
