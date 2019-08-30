<?php

// literally just to unsession the order
session_start();

unset($_SESSION["order"]);

header("Location: /?doneSuccess=true");
exit();
