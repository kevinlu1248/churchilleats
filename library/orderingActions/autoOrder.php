<?php

// TODO: fix all links to home dir

require_once "../conn/query.php";
require_once "nullUserOrderingID.php";
session_start();

class AutoOrder extends Query
{
    private $orderID;
    private $order;
    public $didSucceed = NULL;

    public function __construct(array $user)
    {
        $this->orderID = $user["orderID"];

        $conditions = array(
            "orderID" => $this->orderID
        );

        $this->order = Query::getData(NULL, "orders", $conditions, 1)->result->fetch();
        // var_dump($this->order);
        if ($this->order) {
            // sessionize order here

            $_SESSION["order"] = array(
                "order" => $this->order["foodOrder"], //foods
                "totalCost" => $this->order["cost"],
                "orderID" => $this->order["orderID"],
                "location" => $this->order["location"], //for cancelling
                "orderTime" => $this->order["timeOfOrder"]
            );

            $this->didSucceed = true;
        } else {
            // echo intVal($user["ID"]);
            $nullUserOrderingID = new NullUserOrderingID(intVal($this->$user["ID"]));
            unset($_SESSION["user"]["orderID"]);
        }
    }
}

$user = $_SESSION["user"];

if (!$user) {
    header("Location: http://localhost:8888/churchilleats");
    exit();
}

$autoOrder = new AutoOrder($user);

//checks if order exits

if ($autoOrder->didSucceed) {
    header("Location: http://localhost:8888/churchilleats/signedIn/order/tracking/");
} else {
    header("Location: http://localhost:8888/churchilleats");
}

exit();
