<?php
require_once("./class/User.php");

$user = new User(null, null, null, null, null, null, null);

if ($user->isConnected() == true) {
    $user->disconnect();
    header('Location: ./profil.php');
} else {
    header('Location: ./profil.php');
}
