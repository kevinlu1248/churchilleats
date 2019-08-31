<!-- use scrollspy -->

<script>
    <?php
    // var_dump($_SESSION["order"]);
    if ($_SESSION["order"]) {
        echo "window.location.href = 'signedIn/order/tracking/';";
    }

    if ($_SESSION["user"]["orderID"]) {
        echo "console.log('test');";
        echo "window.location.href = '/churchilleats/library/orderingActions/autoOrder.php';";
    }
    ?>
</script>

<?php
// var_dump($_SESSION["user"]["orderID"]);
?>

<script>
    $("head").append('<link rel="stylesheet" type="text/css" href="signedIn/order/order.css">');
</script>

<!-- add scrollspy -->
<!-- add vending machines -->

<div id="instructions" class="alert alert-success" role="alert"
     style="margin-bottom: 1rem;" <?php if (!$_GET['intro']) {
    echo "hidden";
} ?>>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h3 class="alert-heading">Ordering Page</h3>
    <hr/>
    <p>Welcome to Skip the Line, Churchill's new food delivery system. For details regarding payment, contacting us, or
        any further information, feel free to check the menu in the top left corner.</p>
    <hr>
    <p class="mb-0">Please make your order below by tapping the desired food and choosing how much you want. Once you're
        done, press the "Order Now" panel below.</p>
</div>

<!-- instructions -->

<!-- <h2>
    Ordering Page
</h2>
<h7 class="text-muted" style="margin-bottom: .75rem !important;">
    Please make your order below by tapping the desired food and choosing how much you want.
</h7> -->

<div class="container mb-3 text-light overflow-hidden" id="food-cards-container">
    <div id="food-spinner-container" class="row food-item">
        <div class="col-12 text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div id="instructions-unhider-container">
        <small class="text-muted">Confused about how to order? Load the instructions
            <a id="instructions-unhider">here</a>.</small>
    </div>
</div>

<!-- footer for ordering -->
<footer id="ordering-footer" class="fixed-bottom text-black" role="alert" style="display: none;">
    <form id="ordering-form" action="signedIn/order/location/index.php" method="POST"
          class="d-flex justify-content-center">
        <input type="text" id="order" name="order" hidden>
        <button id="order-now-button" type="submit" class="align-middle align-self-center text-center display-4">
            <i class="fas fa-shopping-cart"></i>&nbsp;Checkout
        </button>

        <div class="row" hidden>
            <div class="col-1" id="dollar-sign">
                $
            </div>
            <div class="col-6" id="total-cost-holder">
                <input id="total-cost" class="display-3" value="0.00" name="totalCost" readonly>
            </div>
            <div id="order-now-button-container" class="col-5">
            </div>
        </div>
    </form>
</footer>

<!-- <script src="https://apis.google.com/js/api.js"></script> -->
<script src="signedIn/order/order.js"></script>
