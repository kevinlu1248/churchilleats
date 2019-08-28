<?php
session_start();

$password = $_POST["password"];
$hash = "password";

if ($password == $hash) {
    $_SESSION["passwordIsCorrect"] = true;
    header("Location: http://localhost:8888/churchilleats/caf/orderPage.php");
} else {
    header("Location: http://localhost:8888/churchilleats/caf/?passwordIncorrect=true");
}

exit();
