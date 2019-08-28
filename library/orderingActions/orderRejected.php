<?php

include_once "../conn/query.php";
include_once "nullUserOrderingID.php";
// literally just to unsession the order
session_start();

class OrderRejected extends Query
{
    private $orderID;
    private $user;
    private $pastOrder;
    public $reason;

    public function __construct($orderID, $user)
    {
        $this->orderID = $orderID;
        $columns = array("rejectionReason");
        $conditions = array(
            "orderID" => $orderID
        );
        $this->pastOrder = Query::getData($columns, "pastOrders", $conditions, 1)->result;
        $this->reason = $this->pastOrder->fetch(PDO::FETCH_NUM)[0];
        $nulling = new NullUserOrderingID($user["ID"]);
    }
}

// var_dump($_SESSION["order"]);
$orderID = $_SESSION["order"]["orderID"];
$user = $_SESSION["user"];
$orderRejected = new OrderRejected($orderID, $user);
$reason = urlencode($orderRejected->reason);
// unset($_SESSION["order"]);
// echo $reason;

header("Location: http://localhost:8888/churchilleats/?orderRejected=true&reason=$reason");
exit();
