<?php

require_once "../conn/query.php";
session_start();

class RejectOrder extends Query
{
    //inputs
    private $post_order;
    private $user;

    //rejecting
    private $orderID;
    private $orderTime;
    private $foodOrder;
    private $totalCost;
    private $userID;
    private $location;
    private $status = "rejected";
    private $rejectionReason;

    private $insertDidSucceed;
    private $deleteDidSucceed;

    public $success;

    public function __construct($post_order, $user, $rejectionReason)
    {
        // inputs
        $this->post_order = $post_order;
        $this->user = $user;

        // rejecting
        $this->orderID = $post_order->orderID;
        $this->orderTime = $post_order->timeOfOrder;
        $this->foodOrder = $post_order->foodOrder;
        $this->totalCost = $post_order->cost;
        $this->userID = $user["ID"];
        $this->location = $post_order->location;
        $this->rejectionReason = $rejectionReason;

        $this->insertOrder();
        $this->deleteOrder();

        $this->success = !($this->insertDidSucceed && $this->deleteDidSucceed);
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
            $this->status,
            $this->rejectionReason
        );

        // var_dump($inputs);
        $this->insertDidSucceed = Query::insert($inputs, 'pastOrders')->errs;
    }

    private function deleteOrder()
    {
        $inputs = array(
            "orderID" => $this->orderID
        );

        $this->deleteDidSucceed = Query::delete($inputs, 'orders', 1)->errs;
    }
}

$post_order = json_decode($_POST["order"]);
$rejectionReason = $_POST["reason"];
$user = $_SESSION["user"];

$rejectOrder = new RejectOrder($post_order, $user, $rejectionReason);
$success = $rejectOrder->success ? "true" : "false";
echo $success;
