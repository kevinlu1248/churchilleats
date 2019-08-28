<?php
require_once '../conn/query.php';
require_once 'sessioner.php';

// class AutoSignin extends Query {
//     private $fingerprint;
//     private $email;
//     private $id;
//     private $hash;
//     public $didSucceed = false;

//     public function __construct(string $fingerprint, string $email, string $hash){
//         $this->fingerprint = $fingerprint;
//         $this->email = $email;
//         $this->id = Query::getIDByEmail($email);;
//         $this->hash = $hash;

//         $this->didSucceed = password_verify($this->fingerprint.$this->id, $hash);
//     }

//     public function test() {
//         return $this->fingerprint.$this->id;
//     }
// }

class AutoSignin extends Query
{
    private $fingerprint;
    private $email;
    private $user;
    public $didSucceed = false;

    public function __construct(string $fingerprint, string $userID)
    {
        $this->fingerprint = $fingerprint;
        $this->userID = $userID;

        $this->user = Query::getUser($userID, "ID")->result->fetch(PDO::FETCH_ASSOC);
        $this->didSucceed = in_array($this->fingerprint, explode(" ", $this->user["fingerprint"]));

        if ($this->didSucceed) {
            $sessioner = new Sessioner($this->user);
            $sessioner->session();
        }
    }
}

$fingerprint = $_POST['fingerprint'];
$userID = $_COOKIE['userID'];
$autoSignin = new AutoSignin($fingerprint, $userID);

// feedback
$didSucceed = $autoSignin->didSucceed;
echo $didSucceed;
