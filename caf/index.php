<?php
require_once '../includes/header.php';
?>

<script>
    // $("head").append('<link rel="stylesheet" type="text/css" href="caf.css">');
</script>

<script>
    <?php
    $test = print_r($_SESSION["user"], true);
    echo "console.log(`$test`);";
    ?>
</script>

<?php
if ($_GET["passwordIncorrect"] == "true") {
    require_once "../banners/cafPasswordIncorrect.php";
}
?>

<div id="entry" class="container p-5 m-x-3 text-center d-flex align-items-center justify-content-center"
     style="padding-bottom: 200px !important;">
    <form class="d-flex justify-content-center" action="../library/caf/verifyPassword.php" method="POST">
        <div id="password-container" class="form-group text-left mr-3">
            <label for="#caf-password">
                Password
            </label>
            <br/>
            <input id="caf-password" name="password" type="password"/>
            <small id="emailHelp" class="form-text text-muted">To enter check the orders</small>
        </div>
        <div id="submit-container" class="d-flex align-items-center">
            <button class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<!-- <div id="modals">
</div> -->

<?php
require_once '../includes/footer.php';
?>
