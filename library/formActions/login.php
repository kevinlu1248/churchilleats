<?php
include_once "../conn/query.php";
include_once "sessioner.php";

//TODO: autologin

class Login extends Query
{
    // user inputted password
    private $password;
    private $userInput;
    private $user;
    private $fingerprint;
    private $didUseStudentID;
    public $passwordIsCorrect;

    public function __construct(string $userInput, string $password, string $fingerprint)
    {
        if (!($userInput && $password && $fingerprint)) {
            $passwordIsCorrect = false;
            return 0;
        }

        $this->userInput = $userInput;
        $this->password = $password;
        $this->didUseStudentID = strpos($this->userInput, "@") === false; // checks if @ is in the string
        $this->user = $this->connectUser();
        $this->fingerprint = $fingerprint;
        $this->passwordIsCorrect = $this->verify();

        if ($this->passwordIsCorrect) {
            $this->sessionize();
            $this->setAutoLogin();
        }
    }

    private function connectUser()
    {
        //get user with this email
        if ($this->didUseStudentID) {
            $user = Query::getUser($this->userInput, "studentID")->result->fetch(PDO::FETCH_ASSOC);
        } else {
            $user = Query::getUser($this->userInput, "email")->result->fetch(PDO::FETCH_ASSOC);
        }
        return $user;
    }

    private function verify()
    {
        //actual password
        $hash = $this->user['password'];
        return password_verify($this->password, $hash);
    }

    private function sessionize()
    {
        $sessioner = new Sessioner($this->user);
        // var_dump($this->user);
        $sessioner->session();
        // var_dump($_SESSION["user"],);
    }

    private function setAutoLogin()
    {
        # updates fingerprint
        $fingerprintString = $this->user["fingerprint"] . " " . $this->fingerprint;
        $columns = array("fingerprint" => $fingerprintString);
        $conditions = array("ID" => $this->user["ID"]);
        $query = Query::update("users", $columns, $conditions, 1);
        // var_dump($query);

        // UPDATE `users` SET `fingerprint` = 'eb49c8bb7e273a58b2fc35b560a77398' WHERE `users`.`ID` = 1;
        // $id = Query::getIDByEmail($this->email);

        # for autologin
        setcookie("userID", $this->user["ID"], time() + 60 * 60 * 24 * 30, "/churchilleats"); #cookie lasts for 30 days
        // echo $this->user["ID"];
        // echo $_COOKIE["userID"];

        // setcookie("hash", Query::pw_hash($this->fingerprint.$this->id), time() + 60 * 60 * 24 * 30, "/"); #cookie lasts for 30 days
    }
}

$fingerprint = $_POST['fingerprint'];
$userInput = $_POST['user'];
$password = $_POST['pwd'];

$login = new Login($userInput, $password, $fingerprint);
$passwordIsCorrect = ($login->passwordIsCorrect) ? 'true' : 'false';
// echo "$URL?passwordIsCorrect=$passwordIsCorrect";
// var_dump($login);
// echo $userInput;

// echo var_dump($_COOKIE["email"]);

// var_dump($_SESSION["user"]);
if ($passwordIsCorrect) {
    header("Location: /");
} else {
    header("Location: /login?passwordIsCorrect=$passwordIsCorrect");
}
exit();
