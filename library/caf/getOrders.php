<?php

require_once "../conn/query.php";

class GetOrders extends Query
{
    private $orders = [];
    public $ordersJSON;

    public function __construct()
    {
        $this->orders = Query::getData(NULL, "orders")->result->fetchAll();
        $this->ordersJSON = json_encode($this->orders);
    }
}

$getOrders = new GetOrders();
$JSON = $getOrders->ordersJSON;

echo $JSON;
