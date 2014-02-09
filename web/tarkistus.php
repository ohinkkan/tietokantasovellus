<?php

require_once 'libs/utilities.php';
require_once 'libs/models/user.php';
require_once 'libs/connection.php';


if (empty($_POST['username'])) {
    displayView('views/kirjaudu.php', array('virhe' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.",));
}
$kayttaja = htmlspecialchars($_POST["username"]);

if (empty($_POST["password"])) {
    displayView('views/kirjaudu.php', array('kayttaja' => $kayttaja, 'virhe' => "Kirjautuminen epäonnistui! Et antanut salasanaa.",));
}
$salasana = htmlspecialchars($_POST["password"]);

$aktiivinen = user::getUser($kayttaja, $salasana);

if (!is_null($aktiivinen)) {
    session_unset();
    $_SESSION['kirjautunut'] = $aktiivinen;
    $_SESSION['userid'] = $aktiivinen->getId();
    header('Location: index.php');
} else {
    displayView('views/kirjaudu.php', array('kayttaja' => $kayttaja, 'virhe' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä.", request));
}



