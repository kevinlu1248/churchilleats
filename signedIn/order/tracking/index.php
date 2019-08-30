<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<!--
Order statuses:
1. serving
2. delivering
3. delivered
Others:
1. cancelled (by users)
2. rejected (by staffs)
3. cancelledLate (cancelled after delivery) might exclude though
-->

<script>
    $("head").append('<link rel="stylesheet" type="text/css" href="tracking.css">');
</script>

<?php
// order info
$session_order = $_SESSION["order"];

if (!$session_order) {
    echo "<script>window.location.href = '/';</script>";
}

$order = $session_order["order"];
$totalCost = $session_order["totalCost"];
$orderID_ = $session_order["orderID"];
$order_array = json_decode($order, true);
$orderID = sprintf("%05d", $orderID_); // adding zero fill

// var_dump($session_order);
?>

<div id="entry" class="p-5 m-x-3">
    <div id="serving">
        <h5 class="text-light">
            Your order is now being served. Your order will be delivered shortly.
        </h5>
        <div id="unaccepted-spinner-container">
            <div class="spinner-grow" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <h5 class="text-light">
            <span id="serving-timer">0</span> seconds since order was made.
        </h5>
        <div id="tracking-footer" class="fixed-bottom row no-gutters">
            <div class="col-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#orderModal">
                    View Order
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-danger" id="cancel-order">Cancel Order</button>
            </div>
        </div>
    </div>
    <div id="delivering" hidden>
        <h5 class="text-white">
            Your order has been accepted. Your order number is
        </h5>
        <h1 class="display-1 text-center text-white" id="orderID">
            <?php echo $orderID; ?>
        </h1>
        <h5 class="text-white">
            Your order will arrive shortly. Please attentively wait your food and have your money ready.
        </h5>
        <div id="tracking-footer" class="fixed-bottom row no-gutters">
            <div class="col-6">
                <button class="btn btn-secondary" data-toggle="modal" data-target="#orderModal">
                    View Order
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-success" data-toggle="modal" data-target="#doneModal">
                    Done
                </button>
            </div>
        </div>
    </div>
    <h5>
        <small class="text-muted">You can find more information regarding ordering regulations <a
                    id="info-link">here</a>.</small>
    </h5>
</div>

<!-- Ordering Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">
                    Your Order
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="order-table">
                    <thead id="order-table-head" class="thead-light">
                    <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Cost</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total Cost</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($order_array as $food) {
                        $name = $food["name"];
                        $cost = number_format($food["cost"], 2);
                        $qty = $food["qty"];
                        $totalCostOfFood = number_format($food["totalCost"], 2);
                        echo "<tr>
                                    <td>$name</td>
                                    <td>$$cost</td>
                                    <td>$qty</td>
                                    <td>$$totalCostOfFood</td>
                                </tr>";
                    }
                    ?>
                    <tr id="last-row">
                        <th scope='row'>Total</th>
                        <td></td>
                        <td></td>
                        <td><strong>$<?php echo $totalCost; ?></strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<!-- Done Modal -->
<div class="modal fade" id="doneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">
                    Are you sure you are done?
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Being done means you have received your order and have paid.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="done-order" type="button" class="btn btn-success">Yes</button>
            </div>
        </div>
    </div>
</div>

<script src="tracking.js"></script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
