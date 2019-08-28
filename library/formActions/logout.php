<?php
require_once "../conn/conn.php";

// echo "Location: $URL?logout=true";
//if (isset($_COOKIE["userID"])) {
//    unset($_COOKIE["userID"]));
//     setcookie("userID", "", time() - 3600);
// };

header("Location: /?logout=true");
exit();
