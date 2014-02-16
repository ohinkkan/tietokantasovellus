<?php

require_once 'libs/utilities.php';
require_once 'libs/models/user.php';
require_once 'libs/connection.php';


if (empty($_POST['username'])) {
    $_SESSION['virhe'] = "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta.";
    displayView('views/kirjaudu.php');
}

$kayttaja = htmlspecialchars($_POST["username"]);

if (empty($_POST["password"])) {
    $_SESSION['virhe'] = "Kirjautuminen epäonnistui! Et antanut salasanaa.";
    displayView('views/kirjaudu.php', array('kayttaja' => $kayttaja,));
}
$salasana = htmlspecialchars($_POST["password"]);

$aktiivinen = user::getUser($kayttaja, $salasana);

if (!is_null($aktiivinen)) {
    session_unset();
    $_SESSION['kirjautunut'] = $aktiivinen;
    $_SESSION['userid'] = $aktiivinen->getId();
    header('Location: index.php');
} else {
    $_SESSION['virhe'] = "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä.";
    displayView('views/kirjaudu.php', array('kayttaja' => $kayttaja, request));
}



