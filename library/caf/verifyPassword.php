<?php
session_start();

$password = $_POST["password"];
$hash = "password";

if ($password == $hash) {
    $_SESSION["passwordIsCorrect"] = true;
    header("Location: /caf/orderPage.php");
} else {
    header("Location: /caf/?passwordIncorrect=true");
}

exit();
