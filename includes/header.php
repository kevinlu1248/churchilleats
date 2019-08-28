<?php
session_start();
#set_include_path(".:../usr/lib/php7.2:../library/includePath.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript"> var start = new Date(); </script>
    <meta charset="utf-8">
    <meta name="description" content="A protoype for an uber eats system.">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#C58917">
    <!--     <base href="/churchilleats/" target="_blank">-->
    <link rel="icon" type="image/jpg" href="/assets/favicon.ico">
    <title>Churchill Eats</title>

    <!--Bower-->
    <!-- <link rel="stylesheet" type="text/css" ref="bower_components/bootstrap/dist/css/bootstrap.css">
    <script src="bower_components/jquery/dist/jquery.js"></script>
    <script src="bower_components/jquery/dist/js/bootstrap.js"></script> -->
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--Bootstrap JS-->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script> -->
    <!-- Bootstrap Toggle -->
    <!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
    <!--User CSS-->
    <link rel="stylesheet" type="text/css" href="/css/main.css" media="screen"/>

    <!--Icons-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!--fingerprint2-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fingerprintjs2/2.0.3/fingerprint2.min.js"
            integrity="sha256-KHjiYfRgjv+1nTnungHdPqfBbH/2C0cO6AMgCciZQJk=" crossorigin="anonymous"></script>
    <!--JQuery-->
    <script
            src="https://code.jquery.com/jquery-3.4.0.min.js"
            integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
            crossorigin="anonymous"></script>
    <!--Toast-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!--Toast css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> -->
    <!--QR Code Generator-->
    <!-- <script src="https://raw.githubusercontent.com/jeromeetienne/jquery-qrcode/master/jquery.qrcode.min.js"></script> -->
    <!--Toast css-->
    <script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>
</head>

<body>
<nav id="nav" class="navbar navbar-expand-lg navbar-light sticky-top row d-flex justify-content-around">

    <!--Navbar Button-->
    <button id="collapsing-button" class="navbar-toggler btn btn-outline-secondary align-center" type="button"
            data-toggle="collapse" data-target=".drop" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <!--Title-->
    <div class="navbar-header">
        <a class="navbar-brand" href="/" id="header-title">
            <img id="logo" src="/assets/skipthelinelogo.png" alt="Image Not Found">
        </a>
    </div>

    <div id="btn-holders" class="d-flex align-items-center" hidden>
        <?php
        $logout = $_GET['logout'];
        if ($logout == "true") {
            unset($_SESSION["user"]);
        }

        $user = $_SESSION["user"];
        // var_dump($user);
        $first = $user["firstName"];
        $last = $user["lastName"];
        $passwordIsCorrect = $_GET["passwordIsCorrect"];
        // $passwordIsCorrect == 0 means that login is incorrect
        if ($logout == "true" || $user == NULL || $passwordIsCorrect == "false") {
            // require_once __DIR__."userDisplay/form.php";
            require_once "userDisplay/form.php";
        } else {
            require_once "userDisplay/user.php";
        }
        ?>
    </div>

</nav>

<!--Dropdown Menus-->
<div class="drop collapse navbar-collapse" id="navbarNav">
    <ul id="navbarNavList" class="navbar-nav ml-4">
        <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/caf">Cafeteria</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
        </li>
    </ul>
</div>

<div id="main" class="padding-x-md img-fluid img-thumbnail">

    <noscript>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Your browser does not support Javascript. Please enable Javascript or use a different browser.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </noscript>

    <?php

    function alert(string $s, string $type)
    {
        echo "<div class=\"alert alert-$type alert-dismissible fade show\" role=\"alert\">
            $s
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
          </button>
        </div>
        ";
    }

    ;

    function danger(string $s)
    {
        alert($s, "danger");
    }

    ;
    function warning(string $s)
    {
        alert($s, "warning");
    }

    ;
    function success(string $s)
    {
        alert($s, "success");
    }

    ;

    if ($_GET["signup"] === "success") {
        include_once "banners/signupSuccess.php";
    }

    if (($_GET["passwordIsCorrect"] == "false" && !$user) || $_GET["updatePasswordIsCorrect"] == "false") {
        require_once "../banners/loginFailure.php";
        unset($_GET["passwordIsCorrect"]);
        unset($_GET["updatePasswordIsCorrect"]);
    }

    if ($_GET["updateSuccess"] == "true") {
        // echo "test";
        require_once "../banners/updateSuccess.php";
    } else if ($_GET["updatePasswordIsCorrect"] == "true") {
        require_once "banners/updateSuccess.php";
    } else if ($_GET["updateSuccess"] == "false" && $_GET["updatePasswordIsCorrect"] == "false") {
        require_once "banners/loginFailure.php";
    }

    if ($user && $_GET["doWelcome"]) {
        include_once "banners/welcomeBack.php";
    }

    if ($_GET["doneSuccess"] == "true") {
        require_once "banners/doneSuccess.php";
    }

    if ($_GET["orderRejected"] == "true") {
        require_once "banners/orderRejected.php";
        unset($_SESSION["order"]);
    }

    // if ($_GET["signup"] == "duplicateerror") {
    //     echo "test";
    //     require_once "../banners/duplicateError.php";
    // }
    if ($_GET["signup"] == "differentPasswords") {
        warning("Your passwords are different.");
    }
    ?>
