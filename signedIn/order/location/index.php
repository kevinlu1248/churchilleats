<?php
require_once '../../../includes/header.php';
?>

<script>
    $("head").append('<link rel="stylesheet" type="text/css" href="location.css">')
</script>

<?php
// order info
$order = $_POST["order"];
$totalCost = $_POST["totalCost"];
$order_array = json_decode($order, true);
// var_dump($order_array);
?>

<div id="entry" class="p-5 m-x-3">
    <form id="location" class="form needs-validation" action="../../../library/orderingActions/sendOrder.php"
          method="POST" novalidate>
        <div class="form-group row">
            <label for=".location">
                Please enter your room number or briefly describe your location and tap "Confirm" below.
            </label>
            <label class="text-muted">
                Please note that if the description is too vague the order may be rejected.
            </label>
            <div class="col-4" id="room-number-container">
                <input id="room-number" type="number" class="location form-control" placeholder="3-Digit #"
                       pattern="^\d{3}$" name="room" autofocus="true">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please enter a valid room number.
                </div>
            </div>
            <div class="col-8" id="described-location-container">
                <input id="described-location" type="text" class="location form-control"
                       placeholder="Or Brief Description of Location" name="description">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please enter a valid description.
                </div>
            </div>
        </div>

        <input id="order" name="order" type="text" value='<?php echo $order; ?>' hidden>
        <input id="totalCost" name="totalCost" type="text" value='<?php echo $totalCost; ?>' hidden>
        <button id="submit-location" type="submit" class="btn btn-success fixed-bottom" disabled>
            <h1 class="display-4 text-white">
                Confirm
            </h1>
        </button>
    </form>

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

<script src="location.js"></script>

<?php
require_once '../../../includes/footer.php';
?>
