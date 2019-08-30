<?php

require_once "../conn/query.php";
session_start();

class GetOrderStatus extends Query
{
    private $orderID;
    private $result;
    public $status;

    public function __construct(int $orderID)
    {
        $this->orderID = $orderID;
        $columns = ["status"];
        $conditions = ["orderID" => $orderID];
        $this->result = Query::getData($columns, "orders", $conditions, 1)->result;
        $this->status = $this->result->fetch(PDO::FETCH_ASSOC)["status"];

        if (!$this->status) {
            $this->result = Query::getData($columns, "pastOrders", $conditions, 1)->result;
            $this->status = $this->result->fetch(PDO::FETCH_ASSOC)["status"];
        };
    }
}

$orderID = $_SESSION["order"]["orderID"];
//var_dump($_SESSION["order"]);
//echo $orderID;

$getOrderStatus = new GetOrderStatus($orderID);
//var_dump($getOrderStatus);
echo $getOrderStatus->status;
