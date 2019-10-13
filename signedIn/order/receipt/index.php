<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<script>
    $("head").append('<link rel="stylesheet" type="text/css" href="receipt.css">')
</script>

<?php
// order info
$order = $_POST["order"];
$totalCost = $_POST["totalCost"];
$order_array = json_decode($order, true);
// var_dump($order_array);
?>

<div id="entry" class="p-5 m-x-3">
    <form id="location" class="form needs-validation" action="/library/orderingActions/sendOrder.php"
          method="POST" novalidate>
        <input id="order" name="order" type="text" value='<?php echo $order; ?>' hidden>
        <input id="totalCost" name="totalCost" type="text" value='<?php echo $totalCost; ?>' hidden>
        <button id="submit-location" type="submit" class="btn btn-success fixed-bottom" disabled>
            <span class="display-4 text-white">
                <i class="fas fa-check"></i>&nbsp;Confirm
            </span>
        </button>
    </form>

    <table class="table" id="order-table">
        <thead id="order-table-head" class="thead-dark">
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
            <td scope='row'>Total</td>
            <td></td>
            <td></td>
            <td><strong>$<?php echo $totalCost; ?></strong></td>
        </tr>
        </tbody>
    </table>
</div>

<script src="location.js"></script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>

