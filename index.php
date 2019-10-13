<?php
require_once 'includes/header.php';
?>

<script>
    <?php
    $test = print_r($_SESSION["user"], true);
    echo "console.log(`$test`);";
    ?>
</script>

<!-- <div id="entry" class="container p-5 m-x-3" style=background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('/churchilleats/assets/homepage.jpg');"> -->
<div id="entry" class="container p-5 m-x-3">
    <div class="row">
        <?php
        //        echo $_GET['updatePasswordIsCorrect'];
        if ($user) {
            require_once "signedIn/order/index.php";
        }
        else {
            require_once "notSignedIn/notSignedIn.php";
        }
        ?>
    </div>
</div>

<!-- <p id="fingerprint">
    Loading your id...
</p>-->

<?php //phpinfo(); ?>

<?php
require_once 'includes/footer.php';
?>
