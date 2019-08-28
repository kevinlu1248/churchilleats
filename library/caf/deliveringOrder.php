<?php

require_once "../conn/query.php";
session_start();

class DeliveringOrder extends Query
{
    private $orderID;
    private $status = "delivering";
    public $success = false;

    public function __construct(string $orderID)
    {
        $this->$orderID = $orderID;

        $columns = array(
            "status" => $this->status
        );

        $conditions = array(
            "orderID" => $orderID
        );

        $this->success = !Query::update("orders", $columns, $conditions, 1)->errs;
    }
}

$orderID = $_POST["orderID"];

$deliveringOrder = new DeliveringOrder($orderID);
$success = $deliveringOrder->success ? "true" : "false";
echo $success;
