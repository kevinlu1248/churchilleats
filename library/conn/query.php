<?php
include_once "conn.php";

#Query returns
class QueryResponse {
    public $errs;
    //PDOStatement
    public $result;
    public $didSucceed;
    public $lastInsertId;

    public function __construct(array $errs, $result, bool $didSucceed = NULL, int $affectedRows = NULL, $lastInsertId = NULL) {
        $this->errs = $errs;
        $this->result = $result;
        $this->didSucceed = $didSucceed;
        $this->lastInsertId = $lastInsertId;
    }

    #Combine responses
    #$this overrides results
    public function append(QueryResponse $other) {
        $this->errs = array_merge($errs, $other->errs);
        $this->didSucceed = ($this->didSucceed && $other->didSucceed);
        return $this;
    }
}

class Query extends Dbh {
    #returns PDOStatement
    #Runs an SQL Query
    //, array $inputs = NULL
    private function run(string $sql, array $inputs = NULL, $getLastInsertID = false) {
        $errs = [];
        //         echo var_dump($inputs);
        //         echo $sql;
        try {
            // with responses
            // if ($inputs === NULL) {
            //     $dbh = new Dbh();
            //     $query = $dbh->connect()->query($sql);
            //     $result = $query;
            // }
            // without responses
            // else {
            // returns PDOStatement
            $dbh = new Dbh();
            $connected = $dbh->connect();
            $result = $connected->prepare($sql);
            if ($inputs) {
                //                 var_dump($sql);
                $didSucceed = $result->execute($inputs);
            }
            else {
                $didSucceed = $result->execute();
            }
            $affectedRows = $result->rowCount();
            // echo $affectedRows;

            $lastInsertId = ($getLastInsertID ? $connected->lastInsertId() : NULL);
        } catch (PDOException $e) {
            $errs[] = $e->getMessage();
        }
        //echo var_dump(new QueryResponse($errs, $result));
        //        echo [$sql, $inputs];
        //        var_dump($sql, $inputs);
        //        var_dump($result->rowCount());
        //         var_dump($affectedRows);

        return new QueryResponse($errs, $result, $didSucceed, $affectedRows, $lastInsertId);
    }

    //Function for inserting data into the database
    //Arr for inputs and table for table
    protected function insert(array $inputs, string $table = "users", $getLastInsertID = false) {
        $sql = "INSERT INTO $table VALUES (?";
        $sql .= str_repeat(",?", count($inputs) - 1);
        $sql .= ");";
        // array_unshift($inputs, $table);
        // for debugging
        // echo $sql;
        // var_dump($inputs);
        return self::run($sql, $inputs, $getLastInsertID);
    }

    //Reads data from the database
    //Null for conditions returns all rows
    //Null for conditions returns all columns
    //Null for limit returns as many as possible
    // SELECT column1, column2, ...
    // FROM table_name;
    protected function getData(array $columns = NULL, string $table = "users", array $conditions = NULL, int $limit = 0) {
        $inputs = array();
        $columnsInput = ($columns === NULL ? "*" : implode(", ", $columns));

        $conditionsInput = ($conditions === NULL ? "" : " WHERE ");
        if ($conditions) {
            foreach ($conditions as $key => $value) {
                $conditionsInput .= "$key = ?, ";
                $input[] = $value;
            }
        }
        $conditionsInput = rtrim($conditionsInput, ", ");

        $limitInput = ($limit === 0 ? "" : " LIMIT $limit");

        $sql = "SELECT $columnsInput FROM $table$conditionsInput$limitInput;";

        //$inputs = [$table, $conditionsInput];
        // var_dump($input);

        if (!$input) {
            $sth = self::run($sql);
            return $sth;
        }

        $sth = self::run($sql, $input);
        return $sth;
    }

    // lIMIT = 0 implies no limits
    // $columns and conditions directly go into the sql string
    //check ../formActions/personalDataChange.php for an example
    protected function update(string $table, array $columns, array $conditions, int $limit = 0) {
        $columnsInput = "";
        $conditionsInput = "";
        $inputs = [];
        foreach ($columns as $key => $value) {
            $inputs[] = $value;
            $columnsInput .= "$key = ?, ";
        }
        foreach ($conditions as $key => $value) {
            $inputs[] = $value;
            $conditionsInput .= "$key = ?, ";
        }
        $columnsInput = rtrim($columnsInput, ", ");
        $conditionsInput = rtrim($conditionsInput, ", ");

        $sql = "UPDATE $table
        SET $columnsInput
        WHERE $conditionsInput";
        if ($limit) {
            $sql .= "\nLIMIT $limit;";
        }

        // $sql = "UPDATE users SET firstName = '?', lastName = '?', studentID = ? WHERE ID = ? LIMIT 1;";
        // var_dump($sql);
        // var_dump($inputs);
        // echo showQuery($sql, $inputs);

        $sth = self::run($sql, $inputs);
        return $sth;
    }

    protected function delete(array $conditions, string $table, int $limit = 0) {
        if (is_array($conditions)) {
            $conditionsInput = "WHERE ";
            $inputs = [];
            foreach ($conditions as $key => $value) {
                $conditionsInput .= "$key=? AND ";
                $inputs[] = $value;
            }
        }
        else {
            $conditionsInput = $conditions;
        }

        $conditionsInput = substr($conditionsInput, 0, -5);

        $limitInput = ($limit == 0 ? "" : " LIMIT $limit");
        $sql = "DELETE FROM $table $conditionsInput$limitInput;";

        // var_dump($inputs);
        // echo $sql;
        return self::run($sql, $inputs);
    }

    public function pw_hash(string $password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function register(string $fingerprint, string $email, string $password, string $firstName, string $lastName, int $isTeacher = 0, int $studentID = 0, int $rememberMe = 0) {
        $errs = [];
        //check for hex
        if (!preg_match('/^[0-9a-f]*$/', $fingerprint)) {
            $errs[] = "fingerprintNotHex";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errs[] = "invalidEmail";
        }
        elseif (strlen($password) > 255) {
            $errs[] = "invalidPassword";
        }
        elseif (!preg_match("/^[a-zA-Z\- ]*$/", $firstName . $lastName)) {
            $errs[] = "invalidName";
        }
        elseif (($studentID > 99999999 | $studentID < 100000) & $studentID != 0) {
            $errs[] = "invalidStudentID";
        }
        elseif ($isTeacher != 1 && $isTeacher != 0) {
            $errs[] = "invalidIsTeacher";
        }
        elseif ($rememberMe != 1 && $rememberMe != 0) {
            $errs[] = "invalidRememberMe";
        }
        elseif (!$errs) {
            try {
                $new_pw = self::pw_hash($password);
                $inputs = [NULL, $fingerprint, $email, $new_pw, $firstName, $lastName, $isTeacher, $studentID, $rememberMe];
                $result = self::insert($inputs);
            } catch (PDOException $e) {
                $errs[] = $e->getMessage();
            }
        }
        $this_result = new QueryResponse($errs, $result->result);
        return $this_result->append($result);
    }

    // columns is list of wanted columns
    protected function getUser(string $value, string $column, array $columns = NULL) {
        return self::getData($columns, "users", array($column => $value), 1);
    }

    // check if row exists in database
    // returns boolean
    // returns if any conditions are fullfilled
    public function existsInDb(array $params, array $columns, string $table) {
        $err1 = count($params) !== count($columns);
        // haystack is list of databases
        $err2 = !in_array($table, ["users"]);
        if ($err1 || $err2) {
            return NULL;
        }
        for ($i = 0; $i < sizeof($params); $i++) {
            $sql = "SELECT COUNT(*) AS count FROM $table WHERE " . $columns[$i] . "='" . $params[$i] . "' LIMIT 1;";
            $test = self::run($sql)->result->fetch()[0];
            //            echo self::run($sql, array(columns[$i], params[$i]));
            //            echo self::run($sql, [$columns[$i], $params[$i]]);
            if ($test) {
                return 1;
            }
            // $test = self::getData(NULL, $table, $columns[$i] . "=" . $params[$i])->result->fetchColumn();
            // echo var_dump($test);
            // if ($test) {
            //     return 1;
            // }
        }
        return 0;
    }

    public function getIDByEmail(string $email) {
        return self::getData(["ID"], "users", array("email" => $email), 1)->result->fetch(PDO::FETCH_NUM)[0];
    }

    public function showQuery($query, $params) {
        $keys = array();
        $values = array();

        # build a regular expression for each parameter
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:' . $key . '/';
            }
            else {
                $keys[] = '/[?]/';
            }

            if (is_numeric($value)) {
                $values[] = intval($value);
            }
            else {
                $values[] = '"' . $value . '"';
            }
        }

        $query = preg_replace($keys, $values, $query, 1, $count);
        return $query;
    }
}
