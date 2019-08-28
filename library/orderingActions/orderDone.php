<?php

// literally just to unsession the order
session_start();

unset($_SESSION["order"]);

header("Location: http://localhost:8888/churchilleats/?doneSuccess=true");
exit();
