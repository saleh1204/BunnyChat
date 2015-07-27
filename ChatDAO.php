<?php

class ChatDAO {

    private $_mysqli;

    function __construct() {
        
    }

    function __destruct() {
        
    }

    private function getDBConnection() {
        if (!isset($_mysqli)) {
            //$_mysqli = new mysqli("localhost", "root", "saleh", "chat");
            $_mysqli = mysql_connect("localhost", "root", "saleh");
            $db = mysql_select_db("chat", $_mysqli);
        }
        return $_mysqli;
    }

    public function excuteQuery($query) {
        $con = $this->getDBConnection();
        $result = mysql_query($query, $con);
        if (mysql_errno()) {
            //echo "MySQL error " . mysql_errno() . ": "
            // . mysql_error() . "\n<br>When executing <br>\n$query\n<br>";
        }
        if (!$result) {
            //  die('Invalid query: ' . mysql_error());
            //$result = NULL;
        }
        return $result;
    }

    public function addUser($username, $password, $email, $gender) {
        //$con = $this->getDBConnection();
        // INSERT INTO `chat`.`login` (`username`, `password`, `admin`, `Email`, `Gender`) VALUES ('saleh', 'saleh', TRUE, 'saleh1204@hotmail.com', 'male');
        $query = 'INSERT INTO login (username, password,Email,Gender) VALUES (\'' . $username . '\', \'' . $password . '\', \'' . $email . '\', \'' . $gender . '\');';
        $this->excuteQuery($query);
    }

    public function isAdmin($username, $password) {
        $query = "select * from login where password='$password' AND username='$username'";
        $result = $this->excuteQuery($query);
        $admin = 0;
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            $admin = $row['admin'];
            return $row['admin'];
        }
        return $admin;
    }

}

?>
