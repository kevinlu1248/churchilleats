<?php

require_once "../conn/query.php";

class NullUserOrderingID extends Query
{
    private $userID;
    public $didSucceed;

    public function __construct(int $userID)
    {
        $this->userID = $userID;

        $columns = array(
            "orderID" => NULL
        );

        $conditions = array(
            "ID" => $this->userID
        );

        $this->didSucceed = Query::update("users", $columns, $conditions, 1)->didSucceed;
    }
}
