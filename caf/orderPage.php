<?php
require_once '../includes/header.php';
?>

<!-- add reasoning to rejection
add delivery button -->

<script>
    <?php
    if (!isset($_SESSION["passwordIsCorrect"])) {
        echo "window.location.href = '../';";
    }
    ?>
    $("head").append('<link rel="stylesheet" type="text/css" href="orderPage.css">');
    $("nav").remove();
</script>

<script>
    <?php
    $test = print_r($_SESSION["user"], true);
    echo "console.log(`$test`);";
    ?>
</script>

<div id="header-container" class="d-flex justify-content-between align-items-stretch">
    <button id="exit-button" class="btn btn-dark d-inline-block">
        <i class="fas fa-times"></i>
    </button>
    <div id="frequency-btn" class="btn-group btn-group-toggle float-right" data-toggle="buttons">
        <label id="frequent-toggle" class="btn btn-secondary active">
            <input type="radio" name="options" id="option1" autocomplete="off" checked>
            Frequent Refresh
        </label>
        <label id="infrequent-toggle" class="btn btn-secondary">
            <input type="radio" name="options" id="option2" autocomplete="off">
            Infrequent Refresh
        </label>
    </div>
</div>

<div id="entry" class="container p-5 m-x-3 text-center align-items-center justify-content-center"
     style="padding-top: 0 !important; max-width: none;">
    <table id="order-table" class="table table-dark table-borderless table-hover table-sm">
        <caption></caption>
        <thead>
        <tr>
            <th scope="col">Order #</th>
            <th scope="col">Name</th>
            <th scope="col">Location</th>
            <th scope="col">Item</th>
            <th scope="col">Qty</th>
            <th scope="col">Cost</th>
            <th scope="col">Total Cost</th>
            <th scope="col">Proceed</th>
            <th scope="col">Reject</th>
        </tr>
        </thead>
        <tbody id="tableBody" statuses="0">
        <!-- placeholder for next row-->
        </tbody>
    </table>
</div>

<div id="modals"></div>

<!-- <div id="toasts"> -->
<!-- </div> -->

<script src="orderPage.js"></script>

<?php
require_once '../includes/footer.php';
?>
