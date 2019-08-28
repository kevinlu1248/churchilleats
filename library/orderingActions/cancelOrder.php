<?php

require_once "../conn/query.php";
require_once "NullUserOrderingID.php";
session_start();

class CancelOrder extends Query
{
    //inputs
    private $session_order;
    private $user;

    //cancelling
    private $orderID;
    private $orderTime;
    private $foodOrder;
    private $totalCost;
    private $userID;
    private $location;
    private $status = "cancelled";

    private $insertDidSucceed;
    private $deleteDidSucceed;
    private $nullingDidSucceed;

    public $success;

    public function __construct($session_order, $user)
    {
        // inputs
        $this->session_order = $session_order;
        $this->user = $user;

        //cancelling
        $this->orderID = $session_order['orderID'];
        $this->orderTime = $session_order['orderTime'];
        $this->foodOrder = $session_order['order'];
        $this->totalCost = $session_order['totalCost'];
        $this->userID = $user["ID"];
        $this->location = $session_order['location'];
        // var_dump($session_order);

        $this->insertOrder();
        $this->deleteOrder();
        $this->sessionizeOrder();
        $this->nullUserOrderingID();

        $this->success = $this->insertDidSucceed && $this->deleteDidSucceed && $this->nullingDidSucceed;
    }

    private function insertOrder()
    {
        $inputs = array(
            $this->orderID,
            $this->orderTime,
            $this->foodOrder,
            $this->totalCost,
            $this->userID,
            $this->location,
            $this->status
        );

        $this->insertDidSucceed = Query::insert($inputs, 'pastOrders')->didSucceed;
    }

    private function deleteOrder()
    {
        $inputs = array(
            "orderID" => $this->orderID
        );

        // var_dump(Query::delete($inputs, 'orders', 1));
        $this->deleteDidSucceed = Query::delete($inputs, 'orders', 1)->didSucceed;
    }

    private function sessionizeOrder()
    {
        unset($_SESSION["order"]);
    }

    private function nullUserOrderingID()
    {
        $nuller = new NullUserOrderingID($this->userID);
        $this->nullingDidSucceed = $nuller->didSucceed;
    }
}

$session_order = $_SESSION["order"];
$user = $_SESSION["user"];

$cancelOrder = new CancelOrder($session_order, $user);
$success = $cancelOrder->success ? "true" : "false";
// var_dump($session_order);
// echo $success;

header("Location: http://localhost:8888/churchilleats?cancelSuccess=$success");
exit();
