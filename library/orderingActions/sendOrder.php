<?php

require_once "../conn/query.php";
session_start();

class Order extends Query
{

    //inputs
    private $user;
    private $order;
    private $room;
    private $description;
    private $totalCost;

    //for sql
    private $foodOrder;
    private $cost;
    private $userID;
    public $location;
    private $fullName;
    private $isTeacher;
    private $status;
    public $timeOfOrder;
    private $timeOfAcceptance;

    public $didSucceed;
    public $orderID;

    public function __construct(array $user, string $order, int $room, string $description, float $totalCost)
    {
        // inputs
        $this->user = $user;
        $this->order = $order;
        $this->room = $room;
        $this->description = $description;
        $this->totalCost = $totalCost;

        //for sql
        $this->foodOrder = $this->order;
        $this->cost = $this->totalCost;
        $this->userID = $this->user["ID"];
        $this->location = ($this->room ? "Room " . $this->room : $this->description);
        $this->fullName = $this->user["firstName"] . " " . $this->user["lastName"];
        $this->isTeacher = $this->user["isTeacher"];
        $this->status = "serving";
        $this->timeOfOrder = date('Y-m-d H:i:s');
        $this->timeOfAcceptance = NULL;

        $inputs = array(
            NULL,
            $this->foodOrder,
            $this->cost,
            $this->userID,
            $this->location,
            $this->fullName,
            $this->isTeacher,
            $this->status,
            $this->timeOfOrder,
            $this->timeOfAcceptance
        );

        $query = Query::insert($inputs, "orders", true);
        $this->didSucceed = $query->didSucceed;
        $this->orderID = (int)$query->lastInsertId;

        // updating users

        $columns = array(
            "orderID" => $this->orderID
        );

        $conditions = array(
            "ID" => $this->userID
        );

        $this->updateUserSuccess = Query::update("users", $columns, $conditions, 1);
    }
}

;

$user = $_SESSION["user"];
$order = $_POST["order"];
$room = $_POST["room"];
$description = $_POST["description"];
$totalCost = $_POST["totalCost"];

$orderMade = new Order($user, $order, $room, $description, $totalCost);
$didSucceed = $orderMade->didSucceed;
$orderID = $orderMade->orderID;
$location = $orderMade->location;
$orderTime = $orderMade->timeOfOrder;

$_SESSION["order"] = array(
    "order" => $order, //foods
    "totalCost" => $totalCost,
    "orderID" => $orderID,
    "location" => $location, //for cancelling
    "orderTime" => $orderTime
);

// var_dump($_SESSION["order"]);

header("Location: /churchilleats/signedIn/order/tracking/?didSucceed=$didSucceed");
exit();

// var_dump($order);
// $foodOrder = json_decode($order, true);
