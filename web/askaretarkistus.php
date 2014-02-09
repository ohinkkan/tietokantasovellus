<?php

require_once 'libs/utilities.php';
require_once 'libs/models/user.php';
require_once 'libs/connection.php';
require_once 'libs/models/task.php';

$name = htmlspecialchars($_POST['name']);
$descr = htmlspecialchars($_POST['descr']);
$priority = htmlspecialchars($_POST['priority']);

if (empty($_POST['name'])) {
    displayView('views/luoaskare.php', array('virhe' => "Et antanut nimeä askareelle.",'name'=>$name,'descr'=>$descr,'priority'=>$priority));
}

if (strlen($name) > 30) {
    displayView('views/luoaskare.php', array('virhe' => "Liian pitkä nimi askareelle.",'name'=>$name,'descr'=>$descr,'priority'=>$priority));
}

if (strlen($descr) > 255) {
    displayView('views/luoaskare.php', array('virhe' => "Liian pitkä kuvaus askareelle.",'name'=>$name,'descr'=>$descr,'priority'=>$priority));
}

if (count($_SESSION['newtasktypes']) < 1) {
    displayView('views/luoaskare.php', array('virhe' => "Ei luokkaa askareella.",'name'=>$name,'descr'=>$descr,'priority'=>$priority));
}


if ($_SESSION['modify']) {
    task::delete($_SESSION['modifytask']);
    task::addTask($name, $descr, $priority);
    displayView('views/etusivu.php', array('note' => "Askaretta muokattu onnistuneesti.",));
} else {
    task::addTask($name, $descr, $priority);
    displayView('views/etusivu.php', array('note' => "Askare lisätty onnistuneesti.",));
}
